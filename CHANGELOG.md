# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.3] - 2026-11-24

### Added

- `no_black_friday_post_slug` filter, to link the bar to a post with a slug other than `black-friday`, without having
  to rename the post or look up its URL yourself with `no_black_friday_url`.
- Dutch (nl_NL) translation.

### Security

- Added an `Update URI` header, so WordPress never offers a wordpress.org plugin with the same slug as an update. The
  slug isn't taken there, so anyone could otherwise publish a plugin under it and have it replace this one on update.

## [1.0.2]

Baseline: earlier history is in the git log.
