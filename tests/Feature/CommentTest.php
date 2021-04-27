<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;
use App\Models\Comment;
use App\Models\Sku;
use App\Models\Order;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * 測試能否正常到我的所有評論頁面
     *
     * @return void
     */
    public function testCommentPage()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/comment');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試能否正常到我的所有評論頁面
     *
     * @return void
     */
    public function testSkuCommentPage()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $response = $this->call('GET', '/comment/1/show');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試能否到商品物品編輯評論頁面
     *
     * @return void
     */
    public function testSkuCommentEditSuccess()
    {
        $this->demoUserLoginIn();
        $comment = factory(Comment::class)->create();
        $response = $this->call('GET', '/comment/1/edit');
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試找不到該商品物品的編輯評論頁面
     *
     * @return void
     */
    public function testSkuCommentEditFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('GET', '/comment/1/edit');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試新增商品物品的評論
     *
     * @return void
     */
    public function testSkuCommentStoreSuccess()
    {
        $this->demoUserLoginIn();
        $sku = factory(Sku::class)->create();
        $order = factory(Order::class)->create();
        $response = $this->call('POST', '/comment/1/store', [
            'comment' => 'test',
        ]);
        $this->assertEquals(200, $response->status());
    }

    /**
     * 測試找不到該商品物品卻要新增評論
     *
     * @return void
     */
    public function testSkuCommentStoreFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('POST', '/comment/999/store');
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試更新評論
     *
     * @return void
     */
    public function testSkuCommentUpdateSuccess()
    {
        $this->demoUserLoginIn();
        $comment = factory(Comment::class)->create();
        $response = $this->call('PATCH', '/comment/1/update', [
            'comment' => 'test',
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試更新不存在的評論
     *
     * @return void
     */
    public function testSkuCommentUpdatFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('PATCH', '/comment/999/update', [
            'comment' => 'test',
        ]);
        $this->assertEquals(404, $response->status());
    }

    /**
     * 測試刪除存在的評論
     *
     * @return void
     */
    public function testSkuCommentDestroySuccess()
    {
        $this->demoUserLoginIn();
        $comment = factory(Comment::class)->create();
        $response = $this->call('DELETE', '/comment/1/destroy');
        $this->assertEquals(302, $response->status());
    }

    /**
     * 測試刪除不存在的評論
     *
     * @return void
     */
    public function testSkuCommentDestroyFailed()
    {
        $this->demoUserLoginIn();
        $response = $this->call('DELETE', '/comment/999/destroy');
        $this->assertEquals(404, $response->status());
    }
}
