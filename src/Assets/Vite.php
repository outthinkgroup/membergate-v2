<?php

namespace Membergate\Assets;

class Vite {
    public string $plugin_url;
    public string $plugin_path;
    public string $module_name;
    public bool $in_dev;
    public string $base_url;
    public array $manifest;

    public function __construct(string $plugin_url, string $plugin_path) {
        $this->plugin_url = $plugin_url;
        $this->plugin_path = $plugin_path;
        $this->module_name = basename($plugin_path);
        $asset_config = $this->asset_info();
        $this->in_dev = $asset_config->env == "development";
        $this->base_url = $this->in_dev ? $asset_config->url : $this->plugin_url . "/assets/dist/";

        $this->manifest = $this->in_dev ? [] : $this->get_manifest();
    }

    public function use(string $script = "assets/main.ts"):void {
        $this->preload_imports($script);
        if (!$this->in_dev) {
            $this->enqueue_css($script);
        }
        $this->enqueue_js($script);
    }

    private function preload_imports(string $script):void {
        if ($this->in_dev) {
            \add_action('wp_head', function () {
                echo '<script type="module">
                    RefreshRuntime.injectIntoGlobalHook(window)
                    window.$RefreshReg$ = () => {}
                    window.$RefreshSig$ = () => (type) => type
                </script>';
            });
            return;
        }
        $links = "";
        foreach ($this->imports($script) as $url) {
            $links .= "<link rel='modulepreload' href='$url'>";
        }
        add_action("wp_head", function () use (&$links) {
            echo $links;
        });
    }

    private function enqueue_css($script) {
        foreach ($this->css_urls($script) as $url) {
            $handle = sprintf("%s/%s", $this->module_name, $script);
            wp_register_style($handle, $url);
            wp_enqueue_style($handle, $url);
        }
    }

    private function enqueue_js($script) {
        $handle = sprintf("module/%s/%s", $this->module_name, $script);
        wp_register_script($handle, $this->asset_url($script), false, $this->in_dev);
        wp_enqueue_script($handle);
    }

    private function imports($script) {
        if (empty($this->manifest[$script]['imports'])) return [];

        return array_map(
            fn ($import) => $this->base_url . $this->manifest[$import]['file'],
            $this->manifest[$script]['imports']
        );
    }

    private function css_urls(string $entry) {
        $urls = [];
        if (isset($this->manifest[$entry]['imports'])) {
            foreach ($this->manifest[$entry]['imports'] as $import) {
                $urls = array_merge($urls, $this->css_urls($import));
            }
        }
        if (!empty($this->manifest[$entry]['css'])) {
            foreach ($this->manifest[$entry]['css'] as $file) {
                $urls[] = $this->base_url . $file;
            }
        }
        return $urls;
    }

    private function asset_url(string $entry) {
        if ($this->in_dev) {
            return $this->base_url . "/" . $entry;
        }
        return isset($this->manifest[$entry])
            ? $this->plugin_url . "assets/dist/" . $this->manifest[$entry]['file']
            : $this->plugin_url . "assets/dist/" . $entry;
    }

    private function asset_info(): array {
        $contents = file_get_contents($this->plugin_path . 'assets/asset-info.json');

        return json_decode($contents);
    }

    private function get_manifest(): array {
        $content = file_get_contents($this->plugin_path . 'assets/dist/manifest.json');
        return json_decode($content, true);
    }

    public function use_esm_modules($tag, $handle, $src) {
        if (false !== stripos($handle, 'module')) {
            $str = "type='module'";
            $str .= $this->in_dev ? ' crossorigin' : '';
            $tag = str_replace("type='text/javascript'", $str, $tag);

            return "<script type='module' src='$src' id='$handle' crossorigin></script>";
        } else {
            return $tag;
        }
    }
}
