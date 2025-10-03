<?php

namespace LaravelSeoPro\Tests\Feature;

use LaravelSeoPro\Models\SeoMeta;
use LaravelSeoPro\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use LaravelSeoPro\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeoMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_seo_meta()
    {
        $seoMeta = SeoMeta::create([
            'seoable_type' => 'TestModel',
            'seoable_id' => 1,
            'title' => 'Test Title',
            'description' => 'Test Description',
        ]);

        $this->assertDatabaseHas('seo_meta', [
            'title' => 'Test Title',
            'description' => 'Test Description',
        ]);
    }

    public function test_has_seo_trait_works()
    {
        $model = new class extends Model {
            use HasSeo;
        };

        $model->id = 1;
        $model->exists = true;

        $seoMeta = $model->getSeoMeta();
        $this->assertInstanceOf(SeoMeta::class, $seoMeta);
    }

    public function test_can_update_seo_meta()
    {
        $model = new class extends Model {
            use HasSeo;
        };

        $model->id = 1;
        $model->exists = true;

        $model->updateSeoMeta([
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

        $this->assertDatabaseHas('seo_meta', [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }
}
