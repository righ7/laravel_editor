<?php

namespace App\Console\Commands;

use App\Admin\CommonMethod\CArticle;
use App\Admin\Models\Article\Article;
use Illuminate\Console\Command;

class SignArticleContentType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:sign_article_content_type {limit=1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '标记文章类型';

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
    public function handle()
    {
        set_time_limit(0);

        $limit = (int)$this->argument('limit') ?? 10000;

        $ids = Article::where('article_content_type', -1)->limit($limit)->orderBy('id','desc')->pluck('id');

        $bar = $this->output->createProgressBar(count($ids));

        foreach ($ids as $id) {
            CArticle::signContentType($id);

            $bar->advance();
        }

        $bar->finish();
    }
}
