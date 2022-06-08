<?php

namespace Spatie\LaravelData\Concerns;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Contracts\IncludeableData as IncludeableDataContract;
use Spatie\LaravelData\Resolvers\PartialsTreeFromRequestResolver;
use Spatie\LaravelData\Support\DataFeature;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

trait ResponsableData
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        if (DataFeature::has($this, IncludeableDataContract::class)) {
            $this->withPartialTrees(
                resolve(PartialsTreeFromRequestResolver::class)->execute($this, $request)
            );
        }

        return new JsonResponse($this->transform(
            wrapExecutionType: WrapExecutionType::Enabled,
        ));
    }

    public static function allowedRequestIncludes(): ?array
    {
        return [];
    }

    public static function allowedRequestExcludes(): ?array
    {
        return [];
    }

    public static function allowedRequestOnly(): ?array
    {
        return [];
    }

    public static function allowedRequestExcept(): ?array
    {
        return [];
    }
}
