# Character visual record template

Add a new object under `characters` in `visual-registry.json` using this shape:

```json
"character-id": {
  "display_name": "Character Name",
  "visual_status": "candidate-v1",
  "story_status": "working",
  "identity_lock": {
    "apparent_age": "",
    "build_and_silhouette": "",
    "face": "",
    "hair": "",
    "facial_hair": "",
    "eyes_and_expression": "",
    "skin_and_distinguishing_features": ""
  },
  "wardrobe_lock": [],
  "color_and_light": [],
  "symbolic_language": [],
  "drift_to_reject": [],
  "references": []
}
```

Use observable visual language. Do not assign race, ancestry, diagnosis, morality, or hidden story information from appearance. Keep uncertain details explicitly uncertain.

Create candidate reference sheets first. After author approval, change `visual_status` to `canonical-v1` and add the approved files with checksums and provenance.

## Minimum reference geometry

Before approval, require three separate files:

- straight-on front view with no head turn or tilt;
- strict 90-degree side profile with one visible eye;
- front three-quarter identity portrait.

Do not treat two nearby three-quarter angles as a substitute. Keep age, face, hair, grooming, wardrobe, lighting, crop, and rendering stable across the set.
