<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;
use Carbon\Carbon;

class CloseShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:closeshop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rolls when closing time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Post $post)
    {
        $today = Carbon::today();
        // 期限が今日の商品のロールを変更する（売切状態にする）
        $post->wheredate('limit', $today)->update(['role' => 10]);
    }
}