#!/usr/bin/env python3
import unittest

from prose_lint import lint


class ProseLintTests(unittest.TestCase):
    def assert_has_flag(self, result, flag_type):
        self.assertTrue(any(flag["type"] == flag_type for flag in result["flags"]))

    def assert_lacks_flag(self, result, flag_type):
        self.assertFalse(any(flag["type"] == flag_type for flag in result["flags"]))

    def test_clean_passes(self):
        text = (
            "George closed the folder and looked at the clerk. The stamp was wrong. "
            "He had seen the same form every month for three years, and the date always sat above the seal.\n\n"
            "The clerk reached for it. George kept his hand on the paper.\n\n"
            '"Who changed this?" he asked.'
        )
        result = lint(text)
        self.assertTrue(result["pass"])
        self.assertEqual(result["flags"], [])

    def test_em_dash_is_error(self):
        result = lint("He knew the answer—then the screen changed.")
        self.assertFalse(result["pass"])
        self.assert_has_flag(result, "em_dash")

    def test_repeated_contrast_template_warns(self):
        text = (
            "It was not a mistake, but a message. "
            "It was not a delay, but a warning. "
            "Nothing else had changed."
        )
        result = lint(text)
        self.assertTrue(result["pass"])
        self.assert_has_flag(result, "not_x_but_y")

    def test_smart_apostrophe_contrast_template_warns(self):
        text = "It wasn’t a mistake. It was a message. It wasn’t a delay. It was a warning."
        result = lint(text)
        self.assertTrue(result["pass"])
        self.assert_has_flag(result, "it_wasnt_it_was")

    def test_repeated_starter_warns_at_three(self):
        text = (
            "He looked at the door. He looked at the desk. He looked at the clerk. "
            "Nobody spoke."
        )
        result = lint(text)
        self.assert_has_flag(result, "repeated_sentence_starters")

    def test_one_sentence_narrative_cluster_warns(self):
        text = "One thing happened.\n\nAnother thing happened.\n\nA third happened.\n\nA fourth happened.\n\nThen this ended."
        result = lint(text)
        self.assert_has_flag(result, "one_sentence_narrative_paragraph_cluster")
        self.assertEqual(result["longest_one_sentence_narrative_run"], 5)

    def test_scattered_one_sentence_paragraphs_do_not_trigger_cluster_warning(self):
        text = (
            "One.\n\nThese two sentences stay together. They break the cadence.\n\n"
            "Two.\n\nThese two sentences stay together. They break the cadence.\n\n"
            "Three.\n\nThese two sentences stay together. They break the cadence.\n\n"
            "Four.\n\nThese two sentences stay together. They break the cadence.\n\n"
            "Five.\n\nSix."
        )
        result = lint(text)
        self.assert_lacks_flag(result, "one_sentence_narrative_paragraph_cluster")

    def test_dialogue_paragraphs_do_not_trigger_cluster_warning(self):
        text = (
            '"Sit down," Samuel said.\n\n'
            '"No."\n\n'
            '"Then stand."\n\n'
            "Konrad left the chair where it was. He put the register on the table and opened it.\n\n"
            '"Three names are gone."\n\n'
            '"I know."'
        )
        result = lint(text)
        self.assert_lacks_flag(result, "one_sentence_narrative_paragraph_cluster")

    def test_variance_metrics_are_descriptive(self):
        text = (
            "Stop. The clerk looked down at the seal. "
            "George had watched that hand certify eleven false inventories without once touching the red edge of the paper."
        )
        result = lint(text)
        summary = result["sentence_word_count_summary"]
        self.assertEqual(summary["count"], 3)
        self.assertEqual(summary["min"], 1)
        self.assertGreater(summary["max"], summary["min"])
        self.assertFalse(any(flag["type"] == "low_variance" for flag in result["flags"]))

    def test_uniform_sentence_lengths_do_not_create_automatic_variance_failure(self):
        text = "One clerk signed today. Two guards waited outside. Three records stayed sealed."
        result = lint(text)
        self.assertTrue(result["pass"])
        self.assertFalse(any("variance" in flag["type"] for flag in result["flags"]))


if __name__ == "__main__":
    unittest.main()
