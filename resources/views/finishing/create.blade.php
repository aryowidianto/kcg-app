<div class="form-group">
    <label for="nama">Nama Finishing</label>
    <input type="text" class="form-control" id="nama" name="nama" required>
</div>

<div class="form-group">
    <label for="hpp_trial">HPP Trial</label>
    <input type="number" class="form-control" id="hpp_trial" name="hpp_trial" required>
</div>

<div class="form-group">
    <label for="mesin_finishing_id">Mesin Finishing</label>
    <select class="form-control" id="mesin_finishing_id" name="mesin_finishing_id" required>
        @foreach($mesinFinishings as $mesin)
            <option value="{{ $mesin->id }}">
                {{ $mesin->nama }} 
                (Kecepatan: {{ $mesin->kecepatan }} unit/jam)
            </option>
        @endforeach
    </select>
</div>