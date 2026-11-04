<?php

use App\Http\Controllers\Admin\CareerPageController;
use App\Models\Page;
use App\Models\User;
use App\Services\ImageStorageService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::factory()->create(['role' => 'admin']);
auth()->login($user);

$page = Page::where('slug', 'tuyen-dung')->first();

// Test 1: no file (just text)
$controller = new CareerPageController(app(ImageStorageService::class));
$request = Request::create('/admin/career', 'POST', [
    '_method' => 'PUT',
    'content' => [
        'masthead' => 'LNT',
        'issue' => 'Số 1',
        'issueNo' => '01',
        'coverImg' => '/images/pages/careers/old.jpg',
        'coverLines' => [['k' => 'A', 'v' => 'B'], ['k' => 'C', 'v' => 'D']],
        'tocKicker' => 'TOC',
        'title' => 'Title',
        'lead' => 'Lead',
        'letter' => 'Letter',
        'signature' => 'Sig',
        'jobLayout' => 'accordion',
        'subLead' => 'Sub',
        'email' => 'a@b.c',
        'zalo' => '123',
        'fanpage' => 'https://fb.com',
        'website' => 'https://a.com',
        'jobs' => [
            ['kicker' => 'K', 'title' => 'T', 'standfirst' => 'S', 'img' => '/old.jpg', 'imgAlt' => '', 'count' => 1, 'status' => 'open', 'type' => 'FT', 'desc' => 'D', 'req' => 'R', 'perks' => 'P'],
            ['kicker' => 'K', 'title' => 'T', 'standfirst' => 'S', 'img' => '/old.jpg', 'imgAlt' => '', 'count' => 1, 'status' => 'open', 'type' => 'FT', 'desc' => 'D', 'req' => 'R', 'perks' => 'P'],
            ['kicker' => 'K', 'title' => 'T', 'standfirst' => 'S', 'img' => '/old.jpg', 'imgAlt' => '', 'count' => 1, 'status' => 'open', 'type' => 'FT', 'desc' => 'D', 'req' => 'R', 'perks' => 'P'],
            ['kicker' => 'K', 'title' => 'T', 'standfirst' => 'S', 'img' => '/old.jpg', 'imgAlt' => '', 'count' => 1, 'status' => 'open', 'type' => 'FT', 'desc' => 'D', 'req' => 'R', 'perks' => 'P'],
        ],
        'steps' => [
            ['code' => '01', 'title' => 'A', 'text' => 'a'],
            ['code' => '02', 'title' => 'B', 'text' => 'b'],
            ['code' => '03', 'title' => 'C', 'text' => 'c'],
            ['code' => '04', 'title' => 'D', 'text' => 'd'],
        ],
    ],
    'is_active' => true,
]);
$request->headers->set('Accept', 'application/json');
try {
    $r = $controller->update($request);
    echo 'TEST1 (no file): '.$r->getStatusCode().' '.$r->getContent().PHP_EOL;
} catch (Throwable $e) {
    echo 'TEST1 EXC: '.$e->getMessage().PHP_EOL;
}

// Check what's in DB after test1
$page->refresh();
echo 'After TEST1, content[coverImg]: '.(json_decode($page->content, true)['coverImg'] ?? 'NULL').PHP_EOL;
echo 'After TEST1, is_active: '.($page->is_active ? 'true' : 'false').PHP_EOL;
