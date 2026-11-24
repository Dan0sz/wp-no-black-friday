# No Black Friday for WordPress

Not doing Black Friday deals, because your price is always the best deal? Tell your visitors. This plugin shows a bar
at the top of your site in November, with a crossed out price tag and a bit of confetti.

![The bar at the top of a site](.github/screenshot.png)

## How to use

Install and activate it. That's it: there are no settings.

- The bar is shown from November 1st until November 30th, in your site's timezone, on every page.
- Do you have a published post with the slug `black-friday`? The bar links to it ("Here's why"). A different slug can
  be set with the `no_black_friday_post_slug` filter.
- Visitors can close the bar. It stays closed for the rest of the year, in that browser. No cookies: it's remembered in
  local storage.
- It works with page caching: a page that's still cached in December doesn't show the bar. A page that was cached in
  October shows it once the cache is refreshed, so clear your cache on November 1st if it's kept for long.
- The confetti doesn't move for visitors who prefer reduced motion.

Your theme must support `wp_body_open` (most themes do).

## Filters

- `no_black_friday_text` — the text on the bar. May contain HTML.
- `no_black_friday_post_slug` — the slug of the post the bar links to. Defaults to `black-friday`:

```php
add_filter( 'no_black_friday_post_slug', fn() => 'no-deals' );
```

- `no_black_friday_url` — where the link goes. Return an empty string for no link.
- `no_black_friday_show` — whether to show the bar, e.g. to preview it in another month:

```php
add_filter( 'no_black_friday_show', '__return_true' );
```

## Styling

The bar uses your theme's fonts. Colors are custom properties you can override in your theme (with a selector like
`body .nbf`):

```css
body .nbf {
    --nbf-from: #1ccaf4; /* Defaults to Kadence's second palette color, if available. */
    --nbf-to: #00adda; /* Defaults to Kadence's first palette color, if available. */
    --nbf-color: #1a202c; /* Defaults to Kadence's third palette color, if available. */
    --nbf-strike: #e11d48;
}
```

## License

MIT
