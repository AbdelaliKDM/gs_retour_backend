<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'id' => $this->id,
        'title' => $this->notice->title,
        'content' => $this->notice->content,
        'type' => $this->notice->type,
        'priority' => $this->notice->priority,
        'metadata' => json_decode($this->notice->metadata),
        'created_at' => $this->created_at,
        'is_read' => boolval($this->is_read),
        'read_at' => $this->read_at,
      ];
    }
}
