<?php

namespace LaravelSeoPro\Contracts;

interface SeoServiceInterface
{
    public function reset(): self;
    public function setTitle(string $title): self;
    public function getTitle(): string;
    public function setDescription(string $description): self;
    public function getDescription(): string;
    public function setKeywords(string $keywords): self;
    public function getKeywords(): string;
    public function setAuthor(string $author): self;
    public function setRobots(string $robots): self;
    public function setCanonicalUrl(string $url): self;
    public function getCanonicalUrl(): ?string;
    public function setOpenGraph(string $property, string $content): self;
    public function setOpenGraphData(array $data): self;
    public function getOpenGraphData(): array;
    public function setTwitterCard(string $name, string $content): self;
    public function setTwitterCardData(array $data): self;
    public function getTwitterCardData(): array;
    public function setJsonLd(array $data): self;
    public function addJsonLd(array $data): self;
    public function getJsonLd(): array;
    public function setAdditionalMeta(array $meta): self;
    public function addMeta(string $name, string $content): self;
    public function getAdditionalMeta(): array;
    public function loadFromModel($model): self;
    public function generateRobots(): string;
    public function generateSitemap(): string;
    public function getAllMeta(): array;
    public function renderMetaTags(): string;
    public function renderOpenGraphTags(): string;
    public function renderTwitterCardTags(): string;
    public function renderJsonLd(): string;
    public function optimize(): self;
    public function getSeoScore(): int;
    public function getRecommendations(): array;
}
