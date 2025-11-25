@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-nav')
<form action="/logout" method="post">
    @csrf
    <button type="submit" class="auth-header-link">ログアウト</button>
</form>
@endsection

@section('content')
<div class="admin-wrapper">

    <h2 class="admin-title">Admin</h2>
    <form action="{{ route('admin.index') }}" method="GET" class="admin-filters" >
        <input type="text" name="name" class="admin-input" placeholder="名前やメールアドレスを入力してください" value="{{ request('name') }}">

        <select name="gender" class="admin-select">
            <option>性別</option>
                <option value="1" {{ request('gender')==1 ? 'selected':'' }}>男性</option>
                <option value="2" {{ request('gender')==2 ? 'selected':'' }}>女性</option>
                <option value="3" {{ request('gender')==3 ? 'selected':'' }}>その他</option>
        </select>

        <select name="detail" class="admin-select">
            <option value="">お問い合わせの種類</option>
            <option value="1.商品のお届けについて"
                {{ request('detail') == '1.商品のお届けについて' ? 'selected' : '' }}>
                1.商品のお届けについて
            </option>
            <option value="2.商品の交換について"
                {{ request('detail') == '2.商品の交換について' ? 'selected' : '' }}>
                2.商品の交換について
            </option>
            <option value="3.商品トラブル"
                {{ request('detail') == '3.商品トラブル' ? 'selected' : '' }}>
                3.商品トラブル
            </option>
            <option value="4.ショップへのお問い合わせ"
                {{ request('detail') == '4.ショップへのお問い合わせ' ? 'selected' : '' }}>
                4.ショップへのお問い合わせ
            </option>
            <option value="5.その他"
                {{ request('detail') == '5.その他' ? 'selected' : '' }}>
                5.その他
            </option>
        </select>

        <input type="text" id="date" class="admin-select" placeholder="年/月/日" value="{{ request('date') }}">
        <script>
        flatpickr("#date", {
            locale: "ja",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "Y年m月d日",
            allowInput: true
        });
        </script>

        <button class="admin-btn search">検索</button>
        <a href="{{ route('admin.index') }}" class="admin-btn reset">リセット</a>
    </form>

    <div class="admin-header-row">

        <a href="{{ route('admin.export', request()->query()) }}" class="export-btn">エクスポート</a>
        <div class="pagination-wrap">
            @if($contacts->onFirstPage())
                <span class="page-btn disabled">&lt;</span>
            @else
                <a href="{{ $contacts->appends(request()->query())->previousPageUrl() }}" class="page-btn">&lt;</a>
            @endif

            @for($i = 1; $i <= $contacts->lastPage(); $i++)
                @if($i == $contacts->currentPage())
                    <span class="page-number active">{{ $i }}</span>
                @else
                    <a href="{{ $contacts->appends(request()->query())->url($i) }}" class="page-number">
                        {{ $i }}
                    </a>
                @endif
            @endfor

            @if($contacts->hasMorePages())
                <a href="{{ $contacts->appends(request()->query())->nextPageUrl() }}" class="page-btn">&gt;</a>
            @else
                <span class="page-btn disabled">&gt;</span>
            @endif

        </div>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>

                <td>
                    @if ($contact->gender == 1)
                        男性
                    @elseif ($contact->gender == 2)
                        女性
                    @else
                        その他
                    @endif
                </td>

                <td>{{ $contact->email }}</td>

                <td>{{ $contact->detail }}</td>

                <td><button class="detail-btn"
                        data-id="{{ $contact->id }}"
                        data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
                        data-gender="{{ $contact->gender }}"
                        data-email="{{ $contact->email }}"
                        data-tel="{{ $contact->tel }}"
                        data-address="{{ $contact->address }}"
                        data-building="{{ $contact->building }}"
                        data-detail="{{ $contact->detail }}"
                        data-content="{{ $contact->content }}">
                        詳細</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>

        <div class="modal-row">
            <span class="modal-label">お名前</span>
            <span class="modal-value" id="modal-name"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">性別</span>
            <span class="modal-value" id="modal-gender"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">メールアドレス</span>
            <span class="modal-value" id="modal-email"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">電話番号</span>
            <span class="modal-value" id="modal-tel"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">住所</span>
            <span class="modal-value" id="modal-address"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">建物名</span>
            <span class="modal-value" id="modal-building"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">お問い合わせの種類</span>
            <span class="modal-value" id="modal-detail"></span>
        </div>

        <div class="modal-row">
            <span class="modal-label">お問い合わせ内容</span>
            <span class="modal-value" id="modal-content-text"></span>
        </div>

        <div class="modal-delete-wrap">
            <form method="POST" id="delete-form" action="{{ route('admin.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="delete-id">
                <button type="submit" class="modal-delete-btn">削除</button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.detail-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;

        fetch(`/admin/contact/${id}`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('modal-name').textContent =
                    data.last_name + ' ' + data.first_name;

                document.getElementById('modal-gender').textContent =
                    data.gender == 1 ? '男性' :
                    data.gender == 2 ? '女性' : 'その他';

                document.getElementById('modal-email').textContent = data.email;
                document.getElementById('modal-tel').textContent = data.tel;
                document.getElementById('modal-address').textContent = data.address;
                document.getElementById('modal-building').textContent = data.building;
                document.getElementById('modal-detail').textContent = data.detail;

                document.getElementById('delete-id').value = id;

                document.getElementById('modal').style.display = 'flex';
            });
    });
});

document.querySelector('.modal-close').addEventListener('click', function () {
    document.getElementById('modal').style.display = 'none';
});

window.addEventListener('click', function(e) {
    if (e.target.id === 'modal') {
        document.getElementById('modal').style.display = 'none';
    }
});
</script>
@endsection
