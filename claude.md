# Claude AI 工作规则

## 核心原则

### 0. CSS 规则（最高优先级 - 用户明确要求）

- ✅ **Web CSS thuần (plain CSS) - 这是唯一源**
- ✅ **No Tailwind, no PostCSS plugin, no preprocessor**
- ✅ **Layout (`layouts/app.blade.php`) chỉ load `asset('css/app.css')`**
- ✅ **`public/css/app.css` 是所有 CSS 的合并源文件**
- ✅ **Build: chạy `powershell build-css.ps1` để consolidate tất cả CSS**
- ❌ **Không thêm Tailwind, Bootstrap, hay bất kỳ CSS framework nào**
- ❌ **Không dùng `@import 'tailwindcss'`, `@layer`, `@apply`**
- ❌ **Không tạo file CSS mới ngoài `public/css/` mà chưa được include trong build script**

**Cấu trúc thư mục CSS:**
```
public/css/
├── app.css                ← FILE CHÍNH (consolidated, không touch trực tiếp)
├── theme.css              ← Design tokens (color, spacing, typography)
├── components.css         ← Buttons, forms, cards, modal
├── navbar.css             ← Top navigation
├── footer.css             ← Footer
├── hero.css, home.css     ← Home page sections
├── products/              ← Product pages subcomponents
└── admin.css              ← Admin layout (riêng)
```

**Quy tắc chỉnh sửa CSS:**
1. **Mọi thay đổi CSS** → sửa file gốc trong `public/css/`
2. **Sau khi sửa** → chạy `powershell build-css.ps1` để regenerate `app.css`
3. **Không sửa trực tiếp `app.css`** (file này được build tự động, sẽ bị ghi đè)
4. **Mobile-first**: Viết CSS cho mobile trước, dùng `min-width` media queries
5. **Breakpoints chuẩn**: `640px` (tablet), `1024px` (desktop), `1280px` (large desktop)

### 1. 不要过度生成文档
- ❌ **禁止**：在完成任务后自动创建总结文档、清单、README 等
- ❌ **禁止**：生成用户没有明确要求的 `.md` 文件
- ✅ **允许**：仅在用户明确要求时创建文档
- ✅ **允许**：更新现有的文档文件（如 README.md）但需谨慎

### 2. 简洁的响应
- 完成任务后，只需简单说明完成了什么
- 不要写长篇大论的总结
- 不要列举所有修改的文件（除非用户要求）
- 不要创建测试脚本（除非用户要求）

### 3. 专注于实际工作
- 优先修复代码问题
- 优先实现功能需求
- 文档是次要的，除非用户明确要求

## 工作流程

### ✅ 正确的工作流程
1. 理解用户需求
2. 修复/实现功能
3. 简单说明完成了什么
4. 等待用户反馈

### ❌ 错误的工作流程
1. 理解用户需求
2. 修复/实现功能
3. ❌ 创建 5 个总结文档
4. ❌ 写 1000 字的完成报告
5. ❌ 创建测试脚本
6. ❌ 更新 3 个 README 文件

## 示例

### ❌ 错误示例：过度文档化
```
用户: 修复语言切换按钮

Claude:
- 修复了按钮
- 创建了 BILINGUAL_OPTIMIZATION.md
- 创建了 BILINGUAL_SUMMARY.md
- 创建了 BILINGUAL_CHECKLIST.md
- 创建了 test-bilingual.ps1
- 更新了 README.md
- 写了 2000 字总结...
```

### ✅ 正确示例：简洁高效
```
用户: 修复语言切换按钮

Claude:
已修复语言切换功能：
- 优化了 localized_url() 函数
- 修复了 9 个视图文件中的路由调用
- 添加了 LocaleController 处理切换

现在可以正常切换语言了，请测试。
```

## 例外情况

### 何时可以创建文档
- ✅ 用户明确说："创建一个文档"
- ✅ 用户明确说："写一个 README"
- ✅ 用户明确说："总结一下"
- ✅ 这是一个全新项目，需要初始文档
- ✅ 用户说："记录一下步骤"

### 何时不要创建文档
- ❌ 完成一个普通的 bug 修复
- ❌ 添加一个小功能
- ❌ 优化代码
- ❌ 用户只是要求修复问题

## 响应模板

### 小修复（1-3个文件）
```
已修复 [问题描述]。
修改了 [文件名]。
```

### 中等改动（4-10个文件）
```
已完成 [任务名称]：
- [主要改动1]
- [主要改动2]
- [主要改动3]

请测试。
```

### 大型改动（10+个文件）
```
已完成 [任务名称]：

核心改动：
- [改动1]
- [改动2]

修改文件：[数量] 个

请测试相关功能。
```

## 记住

1. **用户的时间很宝贵** - 不要让他们阅读不必要的文档
2. **代码比文档重要** - 优先保证代码质量
3. **简洁是美德** - 少即是多
4. **等待明确指令** - 不要假设用户想要什么

## 这个规则本身

- 这个 `claude.md` 文件是应用户要求创建的（例外情况）
- 用户明确说："添加一个规则文件"
- 所以创建这个文件是正确的

---

**总结：少写文档，多写代码。除非用户明确要求。**
