<?php

namespace Modules\Variants\Transformers;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;

class VariantCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'headline' => $this->headline,
            'subheadline' => $this->subheadline,
            'color' => $this->color,
            'layer_url' => $this->layer_url,
            'headline_success' => $this->headline_success,
            'subheadline_success' => $this->subheadline_success,
            'privacy' => $this->privacy,
            'layer_whitelabel_id' => $this->layer_whitelabel_id,
            'layerWhitelabelsList' => $this->layerWhitelabelsList(),
            'logs' => $this->getLogs(),
            'user' => $this->user->first_name . ' ' . $this->user->last_name,
            'logo' => $this->getLogo(),
            'visual' => $this->getVisual(),
        ];
    }

    private function layerWhitelabelsList()
    {
        $layerWhitelabels = app()->make(LayerWhitelabelRepository::class)->withCriteria([
            new ByWhitelabel('layer_whitelabel'),
            new EagerLoad(['whitelabel', 'layer']),
        ])->all();

        return $layerWhitelabels->map(function ($layerWhitelabel) {
            return [
              'id' => $layerWhitelabel->id,
              'whitelabel' => $layerWhitelabel->whitelabel->name,
              'layer' => $layerWhitelabel->layer->name,
            ];
        });
    }

    private function getLogs()
    {
        return app()->make(ActivitiesRepository::class)->byModel($this);
    }

    private function getLogo()
    {
        return [$this->attachments->map(function ($attachment) {
            if ($attachment->type === 'variants/visual') {
                return [
                    'uid'  => $attachment->id,
                    'name' => $attachment->name . '.' . $attachment->extension,
                    'url'  => $attachment->url
                ];
            }
        })->reject(function ($attachment) {
            return empty($attachment);
        })->first()];
    }

    private function getVisual()
    {
        return [$this->attachments->map(function ($attachment) {
            if ($attachment->type === 'variants/logo') {
                return [
                    'uid'  => $attachment->id,
                    'name' => $attachment->name . '.' . $attachment->extension,
                    'url'  => $attachment->url
                ];
            }
        })->reject(function ($attachment) {
            return empty($attachment);
        })->first()];
    }
}
