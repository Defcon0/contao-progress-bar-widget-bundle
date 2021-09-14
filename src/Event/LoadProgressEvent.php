<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ProgressBarWidgetBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class LoadProgressEvent extends Event
{
    const NAME = 'huh.progress_bar_widget.event.load_progress';

    protected array  $data;
    protected string $table;
    protected int    $id;
    protected array  $options;

    public function __construct(array $data, string $table, int $id, array $options = [])
    {
        $this->data = $data;
        $this->table = $table;
        $this->id = $id;
        $this->options = $options;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
