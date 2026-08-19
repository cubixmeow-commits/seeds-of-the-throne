#!/usr/bin/env python3
from prose_lint import lint


def test_clean_passes():
    text = (
        "George closed the folder and looked at the clerk. The stamp was wrong. "
        "He had seen the same form every month for three years, and the date always sat above the seal.\n\n"
        "The clerk reached for it. George kept his hand on the paper.\n\n"
        '"Who changed this?" he asked.'
    )
    result = lint(text)
    assert result["pass"] is True
    assert result["flags"] == []


def test_em_dash_is_error():
    result = lint("He knew the answer—then the screen changed.")
    assert result["pass"] is False
    assert any(flag["type"] == "em_dash" for flag in result["flags"])


def test_repeated_contrast_template_warns():
    text = (
        "It was not a mistake, but a message. "
        "It was not a delay, but a warning. "
        "Nothing else had changed."
    )
    result = lint(text)
    assert result["pass"] is True
    assert any(flag["type"] == "not_x_but_y" for flag in result["flags"])


def test_repeated_starter_warns_at_three():
    text = (
        "He looked at the door. He looked at the desk. He looked at the clerk. "
        "Nobody spoke."
    )
    result = lint(text)
    assert any(flag["type"] == "repeated_sentence_starters" for flag in result["flags"])


def test_one_sentence_narrative_cluster_warns():
    text = "One thing happened.\n\nAnother thing happened.\n\nA third happened.\n\nA fourth happened.\n\nThen this ended."
    result = lint(text)
    assert any(flag["type"] == "one_sentence_narrative_paragraph_cluster" for flag in result["flags"])


def test_dialogue_paragraphs_do_not_trigger_cluster_warning():
    text = (
        '"Sit down," Samuel said.\n\n'
        '"No."\n\n'
        '"Then stand."\n\n'
        "Konrad left the chair where it was. He put the register on the table and opened it.\n\n"
        '"Three names are gone."\n\n'
        '"I know."'
    )
    result = lint(text)
    assert not any(
        flag["type"] == "one_sentence_narrative_paragraph_cluster"
        for flag in result["flags"]
    )


if __name__ == "__main__":
    tests = [
        test_clean_passes,
        test_em_dash_is_error,
        test_repeated_contrast_template_warns,
        test_repeated_starter_warns_at_three,
        test_one_sentence_narrative_cluster_warns,
        test_dialogue_paragraphs_do_not_trigger_cluster_warning,
    ]
    for test in tests:
        test()
        print(f"PASS {test.__name__}")
