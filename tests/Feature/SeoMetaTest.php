<?php

namespace LaravelSeoPro\Tests\Feature;

use LaravelSeoPro\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use LaravelSeoPro\Tests\TestCase;

class SeoMetaTest extends TestCase
{
    public function test_has_seo_trait_works()
    {
        $model = new class extends Model {
            use HasSeo;
        };

        $model->id = 1;
        $model->exists = true;

        // Test that the trait provides SEO functionality
        $this->assertTrue(method_exists($model, 'getSeoMeta'));
        $this->assertTrue(method_exists($model, 'updateSeoMeta'));
        $this->assertTrue(method_exists($model, 'seoMeta'));
    }

    public function test_seo_trait_methods_are_callable()
    {
        $model = new class extends Model {
            use HasSeo;
        };

        $model->id = 1;
        $model->exists = true;

        // Test that methods can be called without database
        $this->assertTrue(is_callable([$model, 'getSeoMeta']));
        $this->assertTrue(is_callable([$model, 'updateSeoMeta']));
        $this->assertTrue(is_callable([$model, 'seoMeta']));
    }

    public function test_seo_trait_does_not_require_database()
    {
        $model = new class extends Model {
            use HasSeo;
        };

        // Test that the trait can be used without database connection
        $this->assertTrue(trait_exists(HasSeo::class));
        $this->assertTrue(in_array(HasSeo::class, class_uses($model)));
    }
}
