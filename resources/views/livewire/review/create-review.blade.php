<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Buat Review
    </div>
    <hr />
    <form wire:submit="create">  <!-- Hanya satu form -->
        <textarea wire:model="review" name="review" class="w-full p-2 border rounded" placeholder="Tulis review Anda"></textarea>
        <input type="hidden" name="id_produk" wire:model="id_produk">
        
        <div class="p-4">
            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>

        </div>
    </form>
</div>
