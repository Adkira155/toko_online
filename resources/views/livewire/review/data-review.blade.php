<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

            <!-- flash message -->
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <!-- end flash message -->

            <a href="/create" wire:navigate class="btn btn-md btn-success rounded shadow-sm border-0 mb-3"></a>
            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-dark text-black">
                            <tr>
                                <th scope="col">Review</th>
                                <th scope="col">Reply</th>
                                <th scope="col" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('/storage/posts/'.$review->review) }}" class="rounded" style="width: 150px">
                                </td>
                                <td>{{ $review->reply }}</td>
                                {{-- <td class="text-center">
                                    <a href="/edit/{{ $review->id }}" wire:navigate class="btn btn-sm btn-primary">EDIT</a>
                                    <button class="btn btn-sm btn-danger">DELETE</button>
                                </td> --}}
                            </tr>
                            @empty
                            <div class="alert alert-danger">
                                Data Post belum Tersedia.
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $reviews->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>