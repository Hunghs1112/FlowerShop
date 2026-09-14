<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * 支持的语言列表
     */
    protected array $supportedLocales = ['vi', 'en'];

    /**
     * 切换语言
     */
    public function switch(Request $request, string $locale)
    {
        // 验证语言是否支持
        if (!in_array($locale, $this->supportedLocales, true)) {
            abort(404);
        }

        // 保存语言到 session
        Session::put('locale', $locale);

        // 获取来源 URL
        $referer = $request->headers->get('referer');
        
        if ($referer) {
            // 尝试从 referer 中提取路由信息
            $parsedUrl = parse_url($referer);
            $path = $parsedUrl['path'] ?? '/';
            $segments = array_filter(explode('/', trim($path, '/')));
            
            // 如果第一个段是语言代码，替换它
            if (!empty($segments) && in_array($segments[0], $this->supportedLocales, true)) {
                $segments[0] = $locale;
                $newPath = '/' . implode('/', $segments);
                
                // 保留查询字符串
                $query = $parsedUrl['query'] ?? '';
                $redirectUrl = $newPath . ($query ? '?' . $query : '');
                
                return redirect($redirectUrl);
            }
        }

        // 默认跳转到首页
        return redirect("/{$locale}");
    }
}
