<?php

namespace Membergate\Assets;

class Vite {
    public static function base_path() {
        global $membergate;

        return $membergate->get_plugin_url() . '/assets/dist/';
    }

    public static function useVite(string $script = 'assets/main.ts') {
        self::jsPreloadImports($script);
        self::cssTag($script);
        self::register($script);
    }

    public static function register($entry) {
        $url = IS_DEVELOPMENT
          ? 'http://localhost:1234/' . $entry
          : self::assetUrl($entry);

        if (! $url) {
            return '';
        }
        $in_footer = IS_DEVELOPMENT ? true : false; // Vite needs it to be in footer for dev
        wp_register_script("module/sage/$entry", $url, false, $in_footer);
        wp_enqueue_script("module/sage/$entry");
    }

    private static function jsPreloadImports($entry) {
        if (IS_DEVELOPMENT) {
            add_action('wp_head', function () {
                echo '<script type="module">
          RefreshRuntime.injectIntoGlobalHook(window)
          window.$RefreshReg$ = () => {}
          window.$RefreshSig$ = () => (type) => type
        </script>';
            });

            return;
        }

        $res = '';
        foreach (self::importsUrls($entry) as $url) {
            $res .= '<link rel="modulepreload" href="' . $url . '">';
        }

        add_action('wp_head', function () use (&$res) {
            echo $res;
        });
    }

      private static function cssTag(string $entry): string {
          // not needed on dev, it's inject by Vite
          if (IS_DEVELOPMENT) {
              return '';
          }

          $tags = '';
          foreach (self::cssUrls($entry) as $url) {
              wp_register_style("sage/$entry", $url);
              wp_enqueue_style("sage/$entry", $url);
          }

          return $tags;
      }

      // Helpers to locate files

      private static function getManifest(): array {
          global $membergate;
          $content = file_get_contents($membergate->get_plugin_path() . 'assets/dist/manifest.json');

          return json_decode($content, true);
      }

      private static function assetUrl(string $entry): string {
          $manifest = self::getManifest();

          return isset($manifest[$entry])
      ? self::base_path() . $manifest[$entry]['file']
      : self::base_path() . $entry;
      }

      private static function getPublicURLBase() {
          return IS_DEVELOPMENT ? '/assets/dist/' : self::base_path();
      }

      private static function importsUrls(string $entry): array {
          $urls = [];
          $manifest = self::getManifest();

          if (! empty($manifest[$entry]['imports'])) {
              foreach ($manifest[$entry]['imports'] as $imports) {
                  $urls[] = self::getPublicURLBase() . $manifest[$imports]['file'];
              }
          }

          return $urls;
      }

      private static function cssUrls(string $entry): array {
          $urls = [];
          $manifest = self::getManifest();

          if (! empty($manifest[$entry]['css'])) {
              foreach ($manifest[$entry]['css'] as $file) {
                  $urls[] = self::getPublicURLBase() . $file;
              }
          }

          return $urls;
      }
}
