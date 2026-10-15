@extends('layouts.admin')

@section('page-title', 'Trang tuyển dụng')

@section('content')
<div class="admin-page-header" style="margin-bottom:24px">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Nội dung trang tuyển dụng</h1>
        <p class="admin-page-subtitle">Các trường bên dưới tương ứng trực tiếp với từng phần trên giao diện LNT Journal.</p>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('career.index') }}" target="_blank" class="btn btn-secondary">Xem trang</a>
        <a href="{{ route('admin.career.applications') }}" class="btn btn-secondary">Hồ sơ ứng tuyển</a>
    </div>
</div>

<form method="POST" action="{{ route('admin.career.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="display:flex;flex-direction:column;gap:24px">
        <section class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Bìa & mục lục</h2></div>
            <div class="admin-card-body career-admin-grid">
                <label>Ấn phẩm<input name="content[masthead]" value="{{ old('content.masthead', $content['masthead']) }}" required></label>
                <label>Số phát hành<input name="content[issueNo]" value="{{ old('content.issueNo', $content['issueNo']) }}" required></label>
                <label class="wide">Dòng mô tả số báo<input name="content[issue]" value="{{ old('content.issue', $content['issue']) }}" required></label>
                <label>Mục lục<input name="content[tocKicker]" value="{{ old('content.tocKicker', $content['tocKicker']) }}" required></label>
                <label>Tiêu đề<input name="content[title]" value="{{ old('content.title', $content['title']) }}" required><small>Dùng *chữ* để in nghiêng.</small></label>
                <label class="wide">Lời dẫn<textarea name="content[lead]" rows="3" required>{{ old('content.lead', $content['lead']) }}</textarea></label>
                <div class="wide career-image-field">
                    <img id="career-cover-preview" src="{{ old('content.coverImg', $content['coverImg']) }}" alt="Ảnh bìa hiện tại">
                    <div>
                        <label>Đường dẫn ảnh bìa<input name="content[coverImg]" value="{{ old('content.coverImg', $content['coverImg']) }}" required></label>
                        <label>Thay ảnh bìa<input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" data-preview="career-cover-preview"></label>
                        <small>Chọn JPG, PNG hoặc WebP, tối đa 4 MB. Ảnh mới sẽ thay ảnh hiện tại khi bấm lưu.</small>
                    </div>
                </div>
                @foreach($content['coverLines'] as $index => $line)
                    <label>Dòng {{ $index + 1 }} – nhãn<input name="content[coverLines][{{ $index }}][k]" value="{{ old("content.coverLines.$index.k", $line['k']) }}" required></label>
                    <label>Dòng {{ $index + 1 }} – nội dung<input name="content[coverLines][{{ $index }}][v]" value="{{ old("content.coverLines.$index.v", $line['v']) }}" required></label>
                @endforeach
            </div>
        </section>

        <section class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Thư toà soạn</h2></div>
            <div class="admin-card-body career-admin-grid">
                <label class="wide">Nội dung<textarea name="content[letter]" rows="7" required>{{ old('content.letter', $content['letter']) }}</textarea><small>Mỗi đoạn cách nhau bằng một dòng mới.</small></label>
                <label class="wide">Chữ ký<input name="content[signature]" value="{{ old('content.signature', $content['signature']) }}" required></label>
            </div>
        </section>

        @foreach($content['jobs'] as $index => $job)
        <section class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Vị trí {{ $index + 1 }} · {{ $job['title'] }}</h2></div>
            <div class="admin-card-body career-admin-grid">
                <label>Chuyên mục<input name="content[jobs][{{ $index }}][kicker]" value="{{ old("content.jobs.$index.kicker", $job['kicker']) }}" required></label>
                <label>Tên vị trí<input name="content[jobs][{{ $index }}][title]" value="{{ old("content.jobs.$index.title", $job['title']) }}" required></label>
                <label>Trạng thái<select name="content[jobs][{{ $index }}][status]" required>@foreach(['open'=>'Đang tuyển','soon'=>'Sắp mở','closed'=>'Đã đủ'] as $value => $label)<option value="{{ $value }}" @selected(old("content.jobs.$index.status", $job['status']) === $value)>{{ $label }}</option>@endforeach</select></label>
                <label>Số lượng<input type="number" min="0" max="99" name="content[jobs][{{ $index }}][count]" value="{{ old("content.jobs.$index.count", $job['count']) }}" required></label>
                <label class="wide">Câu dẫn<input name="content[jobs][{{ $index }}][standfirst]" value="{{ old("content.jobs.$index.standfirst", $job['standfirst']) }}" required></label>
                <label class="wide">Trích dẫn (không bắt buộc)<textarea name="content[jobs][{{ $index }}][quote]" rows="2">{{ old("content.jobs.$index.quote", $job['quote']) }}</textarea></label>
                <label>Loại hình<input name="content[jobs][{{ $index }}][type]" value="{{ old("content.jobs.$index.type", $job['type']) }}" required></label>
                <label>Alt ảnh<input name="content[jobs][{{ $index }}][imgAlt]" value="{{ old("content.jobs.$index.imgAlt", $job['imgAlt']) }}"></label>
                <div class="wide career-image-field">
                    <img id="career-job-preview-{{ $index }}" src="{{ old("content.jobs.$index.img", $job['img']) }}" alt="{{ old("content.jobs.$index.imgAlt", $job['imgAlt']) }}">
                    <div>
                        <label>Đường dẫn ảnh<input name="content[jobs][{{ $index }}][img]" value="{{ old("content.jobs.$index.img", $job['img']) }}" required></label>
                        <label>Thay ảnh vị trí<input type="file" name="job_images[{{ $index }}]" accept="image/jpeg,image/png,image/webp" data-preview="career-job-preview-{{ $index }}"></label>
                        <small>Chọn JPG, PNG hoặc WebP, tối đa 4 MB. Ảnh mới sẽ thay ảnh hiện tại khi bấm lưu.</small>
                    </div>
                </div>
                <label>Mô tả công việc<textarea name="content[jobs][{{ $index }}][desc]" rows="5" required>{{ old("content.jobs.$index.desc", $job['desc']) }}</textarea></label>
                <label>Yêu cầu<textarea name="content[jobs][{{ $index }}][req]" rows="5" required>{{ old("content.jobs.$index.req", $job['req']) }}</textarea></label>
                <label class="wide">Quyền lợi<textarea name="content[jobs][{{ $index }}][perks]" rows="5" required>{{ old("content.jobs.$index.perks", $job['perks']) }}</textarea></label>
            </div>
        </section>
        @endforeach

        <section class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Quy trình ứng tuyển</h2></div>
            <div class="admin-card-body career-admin-grid">
                @foreach($content['steps'] as $index => $step)
                    <label>Bước {{ $index + 1 }} – mã<input name="content[steps][{{ $index }}][code]" value="{{ old("content.steps.$index.code", $step['code']) }}" required></label>
                    <label>Bước {{ $index + 1 }} – tiêu đề<input name="content[steps][{{ $index }}][title]" value="{{ old("content.steps.$index.title", $step['title']) }}" required></label>
                    <label class="wide">Bước {{ $index + 1 }} – mô tả<textarea name="content[steps][{{ $index }}][text]" rows="2" required>{{ old("content.steps.$index.text", $step['text']) }}</textarea></label>
                @endforeach
            </div>
        </section>

        <section class="admin-card">
            <div class="admin-card-header"><h2 class="admin-card-title">Phiếu đăng ký & liên hệ</h2></div>
            <div class="admin-card-body career-admin-grid">
                <label class="wide">Lời dẫn<textarea name="content[subLead]" rows="3" required>{{ old('content.subLead', $content['subLead']) }}</textarea></label>
                <label>Email nhận CV<input type="email" name="content[email]" value="{{ old('content.email', $content['email']) }}" required></label>
                <label>Zalo<input name="content[zalo]" value="{{ old('content.zalo', $content['zalo']) }}" required></label>
                <label>Fanpage<input type="url" name="content[fanpage]" value="{{ old('content.fanpage', $content['fanpage']) }}" required></label>
                <label>Website<input type="url" name="content[website]" value="{{ old('content.website', $content['website']) }}" required></label>
                <label class="wide career-active"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $page->is_active))> Hiển thị trang tuyển dụng</label>
            </div>
        </section>

        <div><button type="submit" class="btn btn-primary">Lưu nội dung</button></div>
    </div>
</form>
@endsection

@push('styles')
<style>
.career-admin-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.career-admin-grid label{display:flex;flex-direction:column;gap:7px;font-size:13px;font-weight:600;color:var(--admin-text-primary)}.career-admin-grid .wide{grid-column:1/-1}.career-admin-grid input:not([type=checkbox]),.career-admin-grid select,.career-admin-grid textarea{width:100%;padding:11px 13px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md);font:inherit;font-weight:400;background:var(--admin-bg)}.career-admin-grid textarea{resize:vertical;line-height:1.5}.career-admin-grid small{font-weight:400;color:var(--admin-text-muted)}.career-image-field{display:grid;grid-template-columns:180px minmax(0,1fr);gap:18px;align-items:start;padding:14px;border:1px solid var(--admin-border);border-radius:var(--admin-radius-md)}.career-image-field>img{width:180px;aspect-ratio:4/5;object-fit:cover;border-radius:8px;background:var(--admin-bg-secondary)}.career-image-field>div{display:grid;gap:12px}.career-active{flex-direction:row!important;align-items:center}.career-active input{width:18px;height:18px}@media(max-width:760px){.career-admin-grid{grid-template-columns:1fr}.career-admin-grid .wide{grid-column:auto}.career-image-field{grid-template-columns:1fr}.career-image-field>img{width:100%;max-height:360px}}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('[data-preview]').forEach(input => input.addEventListener('change', () => {
    const file = input.files?.[0];
    const preview = document.getElementById(input.dataset.preview);
    if (file && preview) preview.src = URL.createObjectURL(file);
}));
</script>
@endpush
