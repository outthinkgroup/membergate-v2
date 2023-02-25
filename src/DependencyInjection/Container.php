<?php

namespace Membergate\DependencyInjection;

class Container implements \ArrayAccess {
    private $locked;

    private $values;

    public function __construct(array $values = []) {
        $this->locked = false;
        $this->values = $values;
    }

    public function configure($configurations) {
        if (! is_array($configurations)) {
            $configurations = [$configurations];
        }

        foreach ($configurations as $configuration) {
            $this->modify($configuration);
        }
    }

    public function service($callable) {
        if (! is_object($callable) || ! method_exists($callable, '__invoke')) {
            throw new \InvalidArgumentException('Service definition is not a closure or invokable object');
        }

        return function (Container $container) use ($callable) {
            static $object;
            if (null == $object) {
                $object = $callable($container);
            }

            return $object;
        };
    }

    private function modify($config) {
        if (is_string($config)) {
            $config = new $config();
        }

        if (! $config instanceof ContainerConfigurationInterface) {
            throw new \InvalidArgumentException('Config object must implement interface ContainerConfigurationInterface');
        }

        $config->modify($this);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool {
        return array_key_exists($offset, $this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key) {
        if (! array_key_exists($key, $this->values)) {
            throw new \InvalidArgumentException(sprintf('Container doesn\'t have a value stored for the "%s" key.', $key));
        } elseif (! $this->is_locked()) {
            $this->lock();
        }

        return $this->values[$key] instanceof \Closure ? $this->values[$key]($this) : $this->values[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value): void {
        if ($this->locked) {
            throw new \RuntimeException('Container is locked and cannot be modified.');
        }

        $this->values[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key): void {
        if ($this->locked) {
            throw new \RuntimeException('Container is locked and cannot be modified.');
        }

        unset($this->values[$key]);
    }

    public function lock() {
        $this->locked = true;
    }

    public function is_locked() {
        return $this->locked;
    }
}
