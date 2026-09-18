# First-Party Visitor Analytics

## Coverage

- the Iain Reid portfolio
- Seeds of the Throne Project Explorer
- the static Seeds story site under `/devsite/docs/`

The shared browser collector posts to `analytics/collect.php`. The story site
loads that collector through its existing `docs/app.js`, so every current story
page participates without becoming a PHP page.

## Recorded fields

- UTC visit time
- site, page path, and page title
- referrer origin and path, without query parameters
- IP address and a derived visitor ID
- browser, operating system, device type, user agent, language, and time zone
- screen dimensions
- approximate city, region, country, and ISP when the IP lookup succeeds
- basic bot classification

The derived visitor ID groups the same IP and browser without setting an
analytics cookie. It is useful for approximate visitor counts, not personal
identification. Carrier networks, VPNs, shared connections, and changing IP
addresses can merge or split visitors.

## Privacy and retention

- no advertising scripts or cross-site tracking
- no analytics cookie
- Global Privacy Control and Do Not Track are honored
- a browser-level opt-out is available on `privacy.php`
- full query strings and URL fragments are not collected
- raw records expire after 180 days
- the public privacy page states that a first-party analytics system is in use

The optional location lookup uses `ipwho.is` from the server and stores only
city/region/country and network-provider fields. It does not store latitude,
longitude, or postal code.

## Security

The analytics tables live inside `data/saas-lab.sqlite`, which is denied over
HTTP by `data/.htaccess`. The private dashboard reuses the existing server-side
administrator authorization. Its CSV export is protected by the same check.

The collector accepts only POST requests for the three approved deployed path
families, limits payload size and field lengths, validates same-origin requests
when an Origin header is present, uses prepared SQL statements, and quietly
fails if analytics storage is unavailable.

## Dashboard

Open `/devsite/iainreiddotdev/admin/analytics.php` while signed in as an
administrator. It provides:

- 1, 7, 30, 90, and 180-day ranges
- site filtering
- optional bot inclusion
- distinct visitors, pageviews, and pages visited
- top pages, approximate locations/networks, referrers, and recent visits
- CSV export of the selected range and site
