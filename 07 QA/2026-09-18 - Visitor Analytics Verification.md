# Visitor Analytics Verification

Status: verified locally with PHP runtime limitation
Date: 2026-09-18

## Implemented

- one cookie-free collector shared by the portfolio, Project Explorer, and Seeds story site
- SQLite visit and IP-location cache tables inside the already protected application database
- raw timestamp, page, referrer path, IP, derived visitor ID, device/browser, approximate location, and ISP records
- administrator-only dashboard with date and site filters, human/bot filtering, recent visits, aggregate tables, and CSV export
- public privacy notice, browser opt-out, Global Privacy Control and Do Not Track support
- automatic 180-day raw-record retention
- server-side cached location lookup that does not retain latitude, longitude, or postal code

## Verification passed

- story site rebuilt: 8 Atlas pages, 10 current workshop modules, and 57 vault projections
- story links, assets, generated hashes, source-linked workshop contract, and curated integration checks
- 9 workshop-contract tests
- visual registry validation
- JavaScript syntax checks
- SQLite analytics schema, indexes, collector insert, and dashboard aggregate query exercised in an in-memory database
- patch and whitespace integrity checks
- deployment documentation and protected-data checks updated

## Runtime limitation

This workspace has no PHP executable, so PHP linting and a live end-to-end collector/dashboard request could not run locally. Deployment verification must confirm that one portfolio visit and one Seeds story visit appear in the protected dashboard and that both the SQLite database and analytics secret return HTTP 403 or 404 when requested directly.
