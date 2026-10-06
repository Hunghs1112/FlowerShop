# Kế hoạch viết lại FlowerShop hoàn toàn bằng Next.js

**Trạng thái:** Bản nháp v0.1  
**Mục tiêu thời gian:** 15–19 tuần cho 1 senior full-stack developer  
**Phạm vi:** Thay toàn bộ Laravel/Blade bằng một ứng dụng Next.js full-stack, giữ nguyên dữ liệu, URL công khai và hành vi nghiệp vụ hiện có.

## 1. Tóm tắt quyết định

Xây ứng dụng Next.js mới song song với hệ thống Laravel đang chạy. Trong lần phát hành đầu tiên:

- Giữ nguyên schema cơ sở dữ liệu và dữ liệu hiện có.
- Giữ nguyên URL public để không mất SEO và liên kết cũ.
- Viết lại storefront, tài khoản khách hàng, admin và backend trong cùng một codebase Next.js.
- Chuyển file upload sang object storage nếu môi trường production không có ổ đĩa bền vững.
- Cutover bằng một khoảng bảo trì ngắn; chưa làm dual-write.
- Giữ Laravel không nhận traffic nhưng vẫn có khả năng đọc/ghi dữ liệu mới trong cửa sổ rollback, sau đó mới gỡ bỏ.

Cách này hoàn thành mục tiêu bỏ Laravel nhưng tránh đồng thời thay framework, schema dữ liệu và nghiệp vụ trong một lần.

## 2. Hiện trạng đã xác nhận

Hệ thống hiện có:

- 104 Blade view, trong đó 55 view thuộc admin.
- 41 controller, 24 model, 16 service và 11 repository.
- 29 bảng được tạo bởi migration, bao gồm user/session, catalog, cart, order, content, VIP, mystery box và chat.
- Storefront: trang chủ, sản phẩm, danh mục, bài viết, trang nội dung, liên hệ và B2C.
- Tài khoản: đăng ký, đăng nhập, quên mật khẩu, hồ sơ và đổi mật khẩu.
- Commerce: giỏ hàng, đặt hàng, quick order, checkout, yêu thích, VIP và mystery box.
- Admin: catalog, biến thể, hình/video, import Excel, bài viết, trang, banner, người dùng, VIP, đơn hàng, inquiry, cấu hình và chat.
- Tích hợp: email, Zalo, Pusher/WebSocket, upload file, database queue và cache.
- Chỉ có vài test nghiệp vụ; phần lớn hành vi hiện tại chưa được khóa bằng test tự động.

## 3. Mục tiêu và ngoài phạm vi

### Mục tiêu

- Loại bỏ PHP/Laravel khỏi production sau giai đoạn ổn định.
- Không mất dữ liệu và không thay đổi kết quả nghiệp vụ đang đúng.
- Giữ nguyên đường dẫn public, metadata SEO và redirect hiện tại.
- Admin có đủ tính năng để vận hành mà không cần Laravel.
- Có test cho các luồng gây mất tiền, mất đơn hoặc mất dữ liệu.
- Có rollback đã diễn tập trước khi cutover.

### Ngoài phạm vi bản đầu

- Redesign toàn bộ giao diện.
- Tách microservice.
- Thay đổi schema chỉ để “đẹp hơn”.
- Viết lại lịch sử migration Laravel thành migration mới từ đầu.
- Dual-write giữa Laravel và Next.js.
- Thay hệ thống thanh toán hoặc bổ sung marketplace chưa có.

Các hạng mục trên chỉ được thêm khi có yêu cầu kinh doanh riêng.

## 4. Kiến trúc đích

### 4.1 Ứng dụng

- Next.js App Router và TypeScript.
- Một ứng dụng modular monolith; không tách frontend/backend thành hai repository.
- Server Components cho trang đọc dữ liệu và SEO.
- Server Actions hoặc Route Handlers cho mutation và API cần public.
- Validation schema dùng chung tại trust boundary.
- Middleware chỉ dùng cho redirect nhẹ; quyền truy cập luôn được kiểm tra lại ở server.

### 4.2 Dữ liệu

- Local và staging chỉ kết nối database riêng hoặc production clone đã masking; không được truy cập trực tiếp production.
- Chỉ bản deploy production mới kết nối database production tại thời điểm cutover.
- ORM được chọn sau khi xác nhận database production; phải introspect được schema hiện hữu và hỗ trợ transaction.
- Không đổi tên bảng/cột trong release đầu.
- Tạo migration mới chỉ cho thay đổi bắt buộc của Next.js, ví dụ bảng token hoặc job.
- Tiền được lưu và tính bằng kiểu số chính xác, không dùng floating point.
- Mọi cột mới phải nullable hoặc có default tương thích để Laravel vẫn đọc/ghi được trong cửa sổ rollback.

### 4.3 Xác thực và phân quyền

- Credentials login tương thích password hash hiện tại hoặc có cơ chế rehash khi người dùng đăng nhập.
- Database session, cookie `httpOnly`, `secure`, `sameSite` phù hợp.
- Phân quyền tối thiểu gồm customer và admin.
- Password reset token một lần, có thời hạn và chống dò quét.
- Rate limit cho login, reset password, contact, B2C và checkout.

### 4.4 File và media

- Giữ nguyên URL media nếu có thể.
- Môi trường có persistent disk có thể tiếp tục dùng file hiện tại trong release đầu.
- Nếu deploy serverless/container không bền vững, migrate sang S3-compatible storage trước cutover và cấu hình Laravel dùng cùng bucket/key convention; nếu Laravel không đọc/ghi được storage mới thì chưa được cutover.
- Upload kiểm tra MIME, kích thước, tên file và quyền sở hữu.
- Không làm image pipeline phức tạp trước khi có số liệu cho thấy cần thiết.

### 4.5 Email, notification và realtime

- Email và Zalo đi qua một lớp notification duy nhất.
- Các tác vụ không bắt buộc phản hồi tức thời được đưa vào queue/outbox để retry an toàn.
- Giữ Pusher nếu production đang dùng; chỉ thay khi chi phí hoặc vận hành là vấn đề thực tế.
- Chat giữ nguyên polling/realtime contract ở bản đầu, không thiết kế lại giao thức.

### 4.6 Triển khai

- Build thành Next.js standalone container hoặc nền tảng tương đương có Node runtime phù hợp.
- Một web process và một worker process bắt buộc cho notification/outbox.
- Database, object storage và email là dịch vụ bên ngoài ứng dụng.
- Logging có request ID; lỗi checkout, notification và upload phải có cảnh báo.
- Bản đầu không thêm application cache cho catalog/giá; chỉ thêm sau load test. Nếu dùng Next.js data cache cho nội dung, mọi mutation admin phải invalidation đúng tag.

### 4.7 Tổ chức code theo domain

Không chuyển cấu trúc Controller/Service/Repository hiện tại sang TypeScript theo tỷ lệ 1:1. Code được chia theo nghiệp vụ, không chia theo loại file toàn cục:

```text
src/
  app/
    (store)/                 # Route và layout cho khách hàng
    (account)/               # Route cần đăng nhập
    admin/                   # Route và layout admin
    api/                     # Chỉ API public/webhook thực sự cần URL
  modules/
    auth/
    catalog/
    cart/
    checkout/
    orders/
    customers/
    content/
    vip/
    mystery-box/
    chat/
    settings/
  components/
    ui/                      # Primitive dùng toàn hệ thống
    shared/                  # Composition dùng qua nhiều domain
  theme/
    tokens.css
    base.css
    admin.css
    resolve-theme.ts
  lib/
    db.ts
    auth.ts
    storage.ts
    mail.ts
    realtime.ts
```

Mỗi module chỉ tạo các file thực sự cần, thường gồm:

```text
catalog/
  index.ts                   # Type và component an toàn cho client
  server.ts                  # Public server API; bắt buộc import `server-only`
  model.ts                   # Type/view model của domain
  schema.ts                  # Validation ở trust boundary
  queries.ts                 # Đọc dữ liệu trên server
  mutations.ts              # Mutation và authorization
  rules.ts                   # Hàm nghiệp vụ thuần nếu có
  components/                # UI chỉ thuộc catalog
```

Không tạo interface repository khi chỉ có một database implementation. ORM được gọi trong `queries.ts`/`mutations.ts`; workflow nhiều bước như checkout nằm trong một use-case function có transaction. Không tạo `BaseRepository`, generic CRUD service hoặc factory chỉ để giảm vài dòng lặp.

Mỗi domain có hai entry point: `index.ts` chỉ export type/schema/component an toàn cho client; `server.ts` có `import 'server-only'` và export query/mutation/use case. Không có barrel tổng gom cả hai phía.

Workflow xuyên domain có đúng một owner. Ví dụ `checkout/use-case.ts` sở hữu orchestration tạo đơn, đọc các bảng cần thiết trong một transaction và gọi các pure rule từ cart/catalog/VIP; các module đó không gọi ngược vào checkout. Sau khi đơn được tạo, module `orders` sở hữu status transition.

### 4.8 Ranh giới logic

Luồng chuẩn của một mutation:

```text
Form/Client event
  → Server Action hoặc Route Handler
  → parse + validate input
  → authenticate + authorize
  → domain rule/use case
  → transaction/database
  → invalidate cache
  → typed result cho UI
```

Quy tắc bắt buộc:

- Giá, tổng tiền, VIP eligibility, trạng thái đơn và quyền truy cập chỉ được quyết định ở server.
- Domain rule là hàm TypeScript thuần, không phụ thuộc React hoặc ORM; ví dụ `calculateCartTotal`, `canTransitionOrder` và `isVipEligible`.
- Server Component được gọi `queries.ts` qua entry point `server.ts`, nhưng mọi React component đều không import ORM trực tiếp và không chứa transaction.
- Query chỉ trả view model tối thiểu cho màn hình, không truyền nguyên ORM entity xuống client.
- Lỗi nghiệp vụ có mã ổn định; UI quyết định cách trình bày thông báo.
- Server Component là mặc định. Chỉ interactive leaf như quantity picker, dialog, uploader hoặc chat composer mới dùng `'use client'`.
- Không tạo API nội bộ chỉ để Server Component gọi lại chính ứng dụng; gọi module server trực tiếp.

### 4.9 Phân cấp component

Component được chia thành bốn cấp với ownership rõ ràng:

| Cấp | Vị trí | Ví dụ | Quy tắc |
|---|---|---|---|
| UI primitive | `components/ui` | Button, Input, Select, Checkbox, Dialog, Table, Badge, Pagination | Không biết domain; chỉ dùng semantic token; hỗ trợ keyboard/focus/error state |
| Shared composition | `components/shared` | SiteHeader, SiteFooter, PageHero, ProductCard, EmptyState, MediaUploader | Dùng ở nhiều domain hoặc cần hình thức thống nhất toàn site |
| Domain component | `modules/*/components` | ProductGallery, VariantPicker, CartSummary, OrderStatus, ProductEditor | Biết type và hành vi của đúng một domain |
| Page-local component | Cùng thư mục route | HomeHero, AboutMap, MysteryBoxConfigurator, dashboard widget riêng | Không export ra ngoài route cho đến khi có nhu cầu dùng lại thật |

Quy tắc quyết định dùng chung hay dùng riêng:

1. Nếu chỉ khác text/data: dùng chung qua props hoặc slot.
2. Nếu cùng cấu trúc nhưng khác một số trạng thái có tên rõ ràng: dùng variant hữu hạn.
3. Nếu khác workflow hoặc accessibility behavior: tách component riêng, không nhồi boolean props.
4. Chỉ nâng component lên `shared` khi có ít nhất hai consumer độc lập hoặc cần cưỡng chế tính nhất quán toàn hệ thống.
5. Không tạo wrapper chỉ để đổi tên một thẻ HTML hoặc một class.

Mapping ban đầu từ Blade:

- `layouts/app`, navbar, footer và promotion bar → store shell dùng chung.
- `layouts/admin` → admin shell riêng; chỉ dùng chung primitive, không ép storefront/admin chung một layout.
- `product-card` và `page-hero` → shared composition.
- Các section riêng của homepage → page-local component.
- Các form admin → dùng chung field primitive và form feedback; schema/action vẫn nằm trong từng domain.
- Autosave dùng một hook/client helper chung, nhưng mỗi domain tự khai báo field được phép và mutation tương ứng.

### 4.10 Theme và design tokens

Theme có ba tầng; component chỉ dùng semantic token thuộc scope hiện tại:

```text
Primitive:  --palette-brown-950, --palette-gold-500, --space-4
Store scope: --bg-canvas, --bg-surface, --text-primary, --border-muted, --action-primary
Admin scope: cùng tên semantic token nhưng mapping riêng cho mật độ và độ tương phản admin
```

Các nhóm token chuẩn:

- Màu semantic: canvas, surface, elevated, text, muted, border, action, success, warning, danger và focus.
- Typography: display, heading, body, label và mono; font được tải tập trung, không import trong component.
- Spacing, container, radius, shadow, motion duration/easing và z-index.
- Breakpoint nằm trong stylesheet; không lưu CSS custom property giả vì custom property không dùng trực tiếp được trong media query.

Runtime theme:

- Primitive token đặt trên `:root`. Store layout có wrapper `[data-theme-scope="store"]`; admin layout có `[data-theme-scope="admin"]`, mỗi scope tự ánh xạ semantic token.
- `resolve-theme.ts` đọc các setting được whitelist, validate và chỉ ánh xạ override vào store scope; admin không vô tình nhận brand color thiếu contrast.
- Không cho admin nhập CSS tự do hoặc tên class.
- Font chỉ chọn từ danh sách đã bundle; màu phải qua validation; contrast được kiểm tra trước khi lưu.
- Logo, banner và nội dung là content setting, không trộn vào design token.
- Storefront dùng brand theme; admin có semantic mapping riêng để bảo đảm độ tương phản và mật độ thao tác.
- Render theme từ server để không nháy màu khi hydrate; không cần Theme Provider phía client cho bản đầu.
- Tận dụng bảng `settings` hiện có cho các override nhỏ; chưa tạo theme engine hoặc bảng theme mới.

Các trường tùy biến ở bản đầu:

- Brand primary/accent.
- Canvas/surface/text/border.
- Display font và body font từ whitelist.
- Radius scale và content width.
- Logo, favicon và ảnh banner theo trang.

Không cho tùy biến spacing tùy ý theo từng trang vì sẽ phá nhịp thiết kế. Nếu sau này có multi-brand thật, thêm theme preset có version thay vì mở toàn bộ CSS.

### 4.11 Contract và kiểm tra UI

- Component public có typed props ngắn, không nhận ORM entity hoặc object `settings` tổng.
- Variant dùng union có tên (`tone="danger"`, `size="compact"`), không dùng chuỗi class truyền tự do cho nghiệp vụ chính.
- Form primitive luôn hỗ trợ label, description, error, disabled và focus-visible.
- Tạo route chỉ có ở development `/dev/ui` để hiển thị token và trạng thái component; chưa thêm Storybook khi route này đã đủ.
- Visual regression chỉ chụp các component/layout cốt lõi và viewport quan trọng, không snapshot mọi pixel.
- Import chéo domain chỉ qua đúng entry point `index.ts` hoặc `server.ts`; không chọc vào file nội bộ và không re-export server code từ client-safe entry point.

## 5. Các giai đoạn thực hiện

| Giai đoạn | Thời lượng | Kết quả bắt buộc |
|---|---:|---|
| 0. Khảo sát và khóa hành vi | 1 tuần | Inventory route, bảng, file, cron/job, email; bộ characterization test cho luồng quan trọng; xác nhận DB production |
| 1. Nền tảng và design system | 2 tuần | Repo chạy được, CI, env validation, DB connection, module boundaries, token theme, UI primitives, layout và deployment thử |
| 2. Auth và data layer | 2 tuần | Login/logout/register/reset, session, RBAC, ORM mapping và transaction primitives |
| 3. Storefront và nội dung | 2 tuần | Home, catalog, product, category, blog, static page, search, contact, B2C và SEO parity |
| 4. Commerce và tài khoản | 2–3 tuần | Cart, checkout, order, profile, favorite, quick order, VIP và mystery box |
| 5. Admin | 3–4 tuần | Toàn bộ CRUD, autosave, upload, variant, import Excel, settings, inquiry/order và chat admin |
| 6. Integration và background work | 1–2 tuần | Email, Zalo, realtime, queue/outbox, retry và operational logging |
| 7. Migration, UAT và cutover | 2–3 tuần | Dry-run, đối soát dữ liệu, kiểm thử tải tối thiểu, rollback rehearsal và production cutover |

**Tổng:** 15–19 tuần cho một senior developer làm toàn thời gian. Đây là estimate sơ bộ; cuối giai đoạn 0 mới chốt được lịch cam kết. Nên cộng thêm 20% nếu giao diện phải pixel-perfect, nghiệp vụ hiện tại chưa được mô tả hoặc production khác đáng kể với repository.

## 6. Chi tiết công việc theo giai đoạn

### Giai đoạn 0 — Khảo sát và khóa hành vi

- Xuất danh sách toàn bộ route, middleware và quyền truy cập.
- Chụp schema production và xác nhận SQLite chỉ là local hay cũng dùng production.
- Lập danh sách cron, queue, webhook, notification và biến môi trường thực tế.
- Đo dung lượng DB/media, lưu lượng, p95 latency, checkout success rate, thời gian backup/restore và tải cao điểm làm baseline.
- Ghi lại payload và kết quả của các luồng: cart, checkout, quick order, VIP, mystery box, upload và import Excel.
- Viết characterization test cho các quy tắc chưa thể đọc chắc chắn từ code.
- Chốt URL, metadata, redirect và canonical cần giữ.

**Điều kiện hoàn thành:** mỗi chức năng hiện tại có owner, dữ liệu vào/ra và tiêu chí parity.

### Giai đoạn 1 — Nền tảng và design system

- Khởi tạo Next.js + TypeScript với lint, typecheck và test command.
- Thiết lập cấu hình môi trường fail-fast, logging và trang lỗi.
- Tạo pipeline build/deploy cho staging.
- Tạo kết nối DB có pooling phù hợp với môi trường chạy.
- Thiết lập ORM tối thiểu và một vertical slice catalog read-only từ route → Server Component → `catalog/server.ts` → `queries.ts` → database clone; phase này không tạo mutation tạm.
- Chuẩn hóa primitive/semantic token, typography và responsive container.
- Xây bộ UI primitive tối thiểu từ nhu cầu thật của storefront/admin.
- Dựng store shell, admin shell, route `/dev/ui` và cơ chế theme override từ settings.
- Import lại asset cần giữ; loại bỏ inline style và alias token cũ khi component tương ứng được chuyển.

**Điều kiện hoàn thành:** staging deploy tự động, truy vấn được database clone, theme đổi được bằng setting whitelist và vertical slice mẫu chứng minh đúng ranh giới server/client/domain.

### Giai đoạn 2 — Auth và data layer

- Map toàn bộ model và quan hệ đang dùng.
- Giữ tương thích password hash; thử bằng bản sao user production đã ẩn dữ liệu nhạy cảm.
- Cài đặt session, CSRF/origin protection, RBAC và password reset.
- Tạo helper transaction dùng cho checkout, order và thao tác nhiều bảng.
- Viết test cho authentication bypass, admin authorization và session expiry.

**Điều kiện hoàn thành:** user cũ đăng nhập được và customer không truy cập được admin.

### Giai đoạn 3 — Storefront và nội dung

- Chuyển lần lượt trang home, product/category listing, detail, blog và content page.
- Giữ slug, pagination, filter, search và empty state.
- Chuyển contact/B2C form với validation, rate limit và notification.
- Đối chiếu title, description, Open Graph, canonical, sitemap và robots.
- So sánh ảnh chụp các viewport chính với hệ thống cũ.

**Điều kiện hoàn thành:** route public đạt parity và không tạo URL 404 mới.

### Giai đoạn 4 — Commerce và tài khoản

- Chuyển cart và tính tổng ở server; client không được quyết định giá cuối.
- Checkout chạy trong transaction và chống submit trùng.
- Tạo order/inquiry và order items từ snapshot giá tại thời điểm đặt.
- Chuyển favorite, profile, password, quick order, VIP và mystery box.
- Test tồn tại sản phẩm, biến thể, trạng thái active và quyền sở hữu dữ liệu.

**Điều kiện hoàn thành:** các hành trình mua hàng quan trọng chạy end-to-end và retry không sinh đơn trùng.

### Giai đoạn 5 — Admin

- Chuyển dashboard và catalog thống nhất.
- CRUD category, subcategory, product, variant, post, page, banner, user, VIP và flower origin.
- Chuyển upload hình/video, chọn ảnh chính, xóa file và kiểm soát orphan file.
- Chuyển autosave nhưng không autosave trường có tác động nguy hiểm nếu chưa có xác nhận UI.
- Chuyển import Excel theo quy tắc đơn giản: validate toàn bộ file trước, sau đó ghi all-or-nothing trong transaction; trả lỗi theo dòng nếu validation thất bại.
- Chuyển order, inquiry, mystery box, settings và chat management.

**Điều kiện hoàn thành:** admin thực hiện được toàn bộ checklist vận hành hằng ngày mà không mở Laravel.

### Giai đoạn 6 — Integration

- Chuyển template email và kiểm tra trên mailbox test.
- Chuyển Zalo notification; secret chỉ tồn tại ở server.
- Cài đặt retry/idempotency cho notification.
- Chuyển chat sang contract tương đương; xác nhận unread count và mark-as-read.
- Thêm health check cho web, DB, worker và storage.

**Điều kiện hoàn thành:** lỗi bên thứ ba không làm mất order và có thể retry/quan sát được.

### Giai đoạn 7 — UAT và cutover

- Tạo bản sao dữ liệu production đã bảo vệ thông tin nhạy cảm để dry-run.
- Chạy script đối soát row count, foreign key, tổng đơn và file tham chiếu.
- Chạy UAT theo vai trò customer/admin.
- Diễn tập rollback ít nhất một lần.
- Bật maintenance/read-only ngắn, backup DB, chạy migration bắt buộc, deploy Next.js và smoke test.
- Theo dõi sát lỗi, order và notification trong 48 giờ đầu.
- Chỉ xóa hạ tầng Laravel sau thời gian ổn định đã thống nhất.

## 7. Chiến lược kiểm thử

Không cố đạt coverage tùy ý. Tập trung vào các lỗi có hậu quả lớn:

- Unit/domain: tính giá, VIP eligibility, cart quantity và status transition.
- Integration: auth/session, transaction checkout, upload, import Excel và notification outbox.
- End-to-end: đăng ký/đăng nhập, tìm sản phẩm, thêm giỏ, checkout, quản lý đơn, CRUD sản phẩm, upload media và chat.
- Security: authorization theo owner/admin, validation upload, rate limit và secret exposure.
- Data reconciliation: số lượng bản ghi, khóa ngoại, tổng tiền và file thiếu.

Mỗi bug production được phát hiện trong migration phải có một regression test trước khi sửa.

## 8. Cutover và rollback

### Cutover mặc định

1. Giảm TTL DNS hoặc chuẩn bị reverse proxy trước ngày chuyển đổi.
2. Tạm khóa mutation trên Laravel, hiển thị thông báo bảo trì và chờ request đang chạy hoàn tất.
3. Backup database và file storage.
4. Chạy migration bổ sung có tính tương thích ngược.
5. Deploy Next.js, chạy smoke test và chuyển traffic.
6. Theo dõi login, checkout, admin mutation, email/Zalo và chat.

Session Laravel không được migrate. Sau cutover, toàn bộ user đăng nhập lại; thông báo việc này trước ngày chuyển đổi.

### Rollback

- Chuyển traffic lại Laravel.
- Không rollback database nếu migration chỉ bổ sung và tương thích ngược.
- Laravel phải đọc/ghi được bản ghi và media do Next.js tạo; điều này được test hai chiều trước cutover.
- Ghi lại mọi thay đổi trong khoảng cutover để đối soát sau sự cố.

Mục tiêu vận hành ban đầu:

- RTO rollback: tối đa 30 phút kể từ quyết định rollback.
- RPO: không mất order đã được hệ thống xác nhận; order và notification dùng transaction/outbox tương ứng.
- Rollback ngay khi có lỗi bảo mật, sai/mất dữ liệu hoặc sai giá đã xác nhận.
- Rollback nếu checkout success rate dưới 95% hoặc 5xx vượt 2% trong 10 phút, trừ khi baseline tuần 1 chứng minh cần ngưỡng chặt hơn.
- Cửa sổ hot rollback là 72 giờ; giữ nguyên hạ tầng Laravel ít nhất 14 ngày trước khi xóa.

Không dùng dual-write ở bản đầu. Chỉ thêm nếu doanh nghiệp không chấp nhận khoảng read-only ngắn và đã tính được chi phí vận hành hai nguồn ghi.

## 9. Tiêu chí nghiệm thu cuối

- 100% route public hiện có giữ URL hoặc có redirect 301 được duyệt; không có khái niệm “route ít quan trọng” bị bỏ ngầm.
- User hiện tại đăng nhập và reset password được.
- User nhận được thông báo và có thể đăng nhập lại sau khi session cũ hết hiệu lực.
- Không thể sửa/xem dữ liệu của user khác hoặc truy cập admin trái phép.
- Cart, checkout và order không sai giá, không tạo trùng khi retry.
- Admin hoàn thành đầy đủ checklist vận hành.
- Email, Zalo và chat hoạt động hoặc retry được khi provider lỗi.
- Tất cả bản ghi và media được đối soát; không còn foreign key mồ côi mới.
- Backup restore và rollback đã được diễn tập.
- Laravel không còn nhận traffic và được giữ tạm chỉ để rollback.
- p95 latency và checkout success rate không kém baseline đã duyệt quá ngưỡng release.

## 10. Nhân sự và lịch dự kiến

### Một senior full-stack

- 15–19 tuần phát triển.
- Cần người nghiệp vụ/admin hỗ trợ UAT khoảng 2–4 giờ mỗi tuần.
- Nên có QA part-time trong 4 tuần cuối.

### Hai developer có kinh nghiệm

- Khoảng 9–12 tuần, không phải một nửa thời gian vì auth, data model, cutover và review là đường găng chung.
- Chia luồng hợp lý: một người storefront/commerce, một người admin/integration; cùng sở hữu auth và data layer.

## 11. Rủi ro chính

| Rủi ro | Giảm thiểu |
|---|---|
| Nghiệp vụ ẩn trong Blade/JavaScript | Characterization test và checklist parity trước khi code |
| Test hiện tại quá ít | Khóa trước các luồng tiền, quyền và dữ liệu |
| Database production khác cấu hình local | Chụp schema và thử trên clone trong tuần 1 |
| Password hash/session không tương thích | Test user cũ sớm; cho đăng nhập lại sau cutover |
| Mất SEO | Giữ URL, metadata, redirect và crawl staging |
| Upload/file bị mất | Inventory, checksum và backup trước cutover |
| Notification tạo trùng | Idempotency key và outbox |
| Scope phình thành redesign | Tách redesign thành dự án sau parity |

## 12. Các quyết định cần chốt trong tuần đầu

1. Database production thực tế là SQLite, MySQL hay PostgreSQL?
2. Nơi deploy Next.js có persistent disk và long-running worker không?
3. Có bắt buộc giữ nguyên giao diện pixel-perfect không?
4. Khoảng maintenance/read-only tối đa được chấp nhận là bao lâu?
5. Pusher, Swoole/WebSocket và Zalo hiện có đang được dùng thật ở production không?
6. Có dữ liệu thanh toán hoặc integration ngoài repository không?
7. Ai là người duyệt UAT cho storefront và admin?
8. Owner go/no-go, incident commander và người trực 48 giờ đầu là ai?
9. Baseline và ngưỡng release cuối cùng cho latency, error rate, checkout success và SEO traffic là gì?

## 13. Mốc go/no-go

- **Cuối tuần 1:** chỉ tiếp tục khi đã xác nhận DB, integrations và checklist parity.
- **Cuối tuần 5:** auth/data layer phải chạy với dữ liệu clone; nếu không, điều chỉnh estimate.
- **Cuối tuần 10:** storefront và commerce phải qua E2E; không bắt đầu cutover khi còn sai nghiệp vụ tiền.
- **Trước production:** UAT, backup restore và rollback rehearsal đều phải đạt.
