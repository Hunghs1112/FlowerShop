<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
    <!-- Logo + Mobile Close -->
    <div class="admin-sidebar-header">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-logo">
            <div class="admin-logo-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <div class="admin-logo-text">
                <span class="admin-logo-title">Lâm Nhiên Thảo</span>
                <span class="admin-logo-subtitle">Admin Panel</span>
            </div>
        </a>
        <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Đóng menu">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="admin-sidebar-nav">
        <div class="admin-nav-section">
            <div class="admin-nav-section-title">Chính</div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="admin-nav-text">Bảng Điều Khiển</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="admin-nav-section">
            <div class="admin-nav-section-title">Quản Lý</div>
            <ul class="admin-nav">
                
                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.catalog.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.catalog.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.subcategories.*') || request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="admin-nav-text">Quản Lý Catalog</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.inquiries.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.inquiries.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="admin-nav-text">Liên Hệ</span>
                        <?php if(isset($stats['new_inquiries']) && $stats['new_inquiries'] > 0): ?>
                            <span class="admin-nav-badge"><?php echo e($stats['new_inquiries']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.mystery-boxes.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.mystery-boxes.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="admin-nav-text">Mystery Box</span>
                        <?php
                            $newMysteryBoxCount = \App\Models\MysteryBoxRequest::where('status', 'new')->count();
                        ?>
                        <?php if($newMysteryBoxCount > 0): ?>
                            <span class="admin-nav-badge"><?php echo e($newMysteryBoxCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.mystery-box-content.edit')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.mystery-box-content.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m4-2a8 8 0 11-16 0 8 8 0 0116 0z"/>
                        </svg>
                        <span class="admin-nav-text">Nội Dung Mystery Box</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.posts.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.posts.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span class="admin-nav-text">Bài Viết</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="admin-nav-section">
            <div class="admin-nav-section-title">Hệ Thống</div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.chats.index')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.chats.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="admin-nav-text">Chat</span>
                        <?php
                            $unreadChatCount = \App\Models\ChatMessage::where('is_admin', false)->where('is_read', false)->count();
                        ?>
                        <?php if($unreadChatCount > 0): ?>
                            <span class="admin-nav-badge"><?php echo e($unreadChatCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="admin-nav-text">Người Dùng</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.vip-levels.index')); ?>"
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.vip-levels.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span class="admin-nav-text">VIP Levels</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.banners.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="admin-nav-text">Banner</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.pages.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.pages.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="admin-nav-text">Trang</span>
                    </a>
                </li>

                <li class="admin-nav-item">
                    <a href="<?php echo e(route('admin.settings.index')); ?>" 
                       class="admin-nav-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>">
                        <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="admin-nav-text">Cài Đặt</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Footer -->
    <div class="admin-sidebar-footer">
        <a href="<?php echo e(route('home')); ?>" class="admin-nav-link">
            <svg class="admin-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span class="admin-nav-text">Xem Trang Web</span>
        </a>
    </div>
</aside>
<?php /**PATH /root/FlowerShop/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>