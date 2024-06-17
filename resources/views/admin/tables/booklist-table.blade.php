<div class="container">
    <table class="table">
        <thead>
        <tr class="table-dark">
            <th scope="col" class="text-center" style="width: 1em">ID</th>
            <th scope="col" class="text-center" style="width: 8em">Cover</th>
            <th scope="col">Judul</th>
            <th scope="col">Status</th>
            <th scope="col" style="width: 10em"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr style="height: 4em" class="text-align-center">
                <td class="align-middle text-center">{{ $book->id }}</td>
                <td class="align-middle text-center">
                    <img onerror="this.onerror=null; this.src='/img/default_book.jpg';" src="/img/books/{{$book->cover_image}}.jpg" alt="{{$book->name}}" style="width: 40px;">
                </td>
                <td class="align-middle">
                    {{$book->name}}
                </td>
                <td class="align-middle status-cell {{$book->active ? "text-success" : "text-danger"}}" data-book-id="{{ $book->id }}">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="flexSwitchCheckDefault{{$book->id}}">{{$book->active ? "Aktif" : "Non Aktif"}}</label>
                        <input class="form-check-input book-switch" type="checkbox" role="switch" id="flexSwitchCheckDefault{{$book->id}}"
                               data-book-id="{{ $book->id }}" {{ $book->active ? 'checked' : '' }}>
                    </div>
                </td>
{{--                Pop up setelah berhasil ngubah status buku --}}
                <div class="toast-container position-absolute bottom-0 end-0 p-3">
                    <div id="statusBookToast{{$book->id}}" class="toast bg-light-subtle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                        <div class="toast-header">
                            <strong class="me-auto">Neobook</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Status buku "{{$book->name}}" berhasil menjadi <span class="toast-status"></span>
                        </div>
                    </div>
                </div>

                <td class="align-middle">
                    <a href="/admin/booklist/updatebook/{{$book->id}}/edit" class="btn btn-secondary">
                        Ubah
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex text-center justify-content-center text-align-center">
        {{ $books instanceof \Illuminate\Pagination\LengthAwarePaginator ? $books->onEachSide(1)->links('vendor.pagination.bootstrap-4') : '' }}
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('.book-switch').change(function() {
            var isActive = $(this).is(':checked');
            var bookId = $(this).data('book-id');
            const statusToastElement = document.getElementById('statusBookToast' + bookId);

            fetch('/admin/booklist/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: bookId,
                    active: isActive
                })
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    // Update the status in the DOM
                    var statusCell = $('.status-cell[data-book-id="' + bookId + '"]');
                    var statusLabel = statusCell.find('label.form-check-label');
                    var statusInput = statusCell.find('input.book-switch');
                    var toastStatus = statusToastElement.querySelector('.toast-status');

                    if (data.book.active) {
                        statusCell.removeClass('text-danger').addClass('text-success');
                        statusLabel.text('Aktif');
                        toastStatus.textContent = '\"Aktif\"';
                    } else {
                        statusCell.removeClass('text-success').addClass('text-danger');
                        statusLabel.text('Non Aktif');
                        toastStatus.textContent = '\"Non-Aktif\"';
                    }

                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(statusToastElement);
                    toastBootstrap.show();
                } else {
                    console.error('Error updating status');
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
