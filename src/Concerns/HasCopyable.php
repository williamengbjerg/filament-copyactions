<?php

namespace Webbingbrasil\FilamentCopyActions\Concerns;

use Closure;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

trait HasCopyable
{
    protected Closure | string | null $copyable = null;

    public static function getDefaultName(): ?string
    {
        return 'copy';
    }

    public function setUp(): void
    {
        parent::setUp();

        $successNotificationTitle = $this->getSuccessNotificationTitle();

        $this
            ->successNotificationTitle(__('Copied!'))
            ->icon('heroicon-o-clipboard-copy')
            ->extraAttributes(fn () => [
                'x-data' => '',
                'x-on:click' => new HtmlString(
                    'window.navigator.clipboard.writeText('.Js::from($this->getCopyable()).');'
                    . ($successNotificationTitle ? ' $tooltip('.Js::from($successNotificationTitle).');' : '')
                ),
            ]);
    }

    public function copyable(Closure | string | null $copyable): self
    {
        $this->copyable = $copyable;

        return $this;
    }

    public function getCopyable(): ?string
    {
        return $this->evaluate($this->copyable);
    }
}
