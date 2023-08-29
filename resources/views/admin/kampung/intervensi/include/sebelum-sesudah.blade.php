<div id="jenis_post_id_{{ $jenisPost->id }}" class="row jenis-post-container">
    @foreach($jenisPost->intervensi_gambar_types as $keyGambarType => $gambarType)
        <div class="col-6">
            <h3>{{ $gambarType->name }}</h3>
            <div class="sona-container" id="sebelum_sesudah_{{ $gambarType->id }}">
                <fieldset id="fieldsetKegiatan">
                    <div class="sonas">
                        <div class="sona">
                            <img class="preview-image"
                                @if(old("intervensi_gambars.{$keyGambarType}.base64"))
                                    src="{{ old("intervensi_gambars.{$keyGambarType}.base64") }}"
                                @elseif(isset($intervensiGambarMap[$gambarType->id]['url']))
                                    src="{{ $intervensiGambarMap[$gambarType->id]['url'] }}"
                                @else
                                    src="https://kampungkb.bkkbn.go.id/assets/images/default-intervensi.png"
                                @endif
                            alt="Preview">
                            <span class="preview-details">
                                {{ Form::hidden(
                                    "intervensi_gambars[$keyGambarType][base64]",
                                    $intervensiGambarMap[$gambarType->id]['base64'] ?? null,
                                    ['class' => 'base-image']
                                ) }}
                                {{ Form::hidden(
                                    "intervensi_gambars[$keyGambarType][intervensi_gambar_type_id]",
                                    $gambarType->id,
                                ) }}
                                {{ Form::file(
                                    "",
                                    [
                                        'accept' => 'image/*',
                                        'class' => 'uploader-input hidden'
                                    ]
                                ) }}


                                {{ Form::text(
                                    "intervensi_gambars[$keyGambarType][caption]",
                                    $intervensiGambarMap[$gambarType->id]['caption'] ?? null,
                                    [
                                        'class' => 'preview-caption',
                                        'placeholder' => 'Caption gambar...',
                                    ]
                                ) }}

                                {{ Form::hidden(
                                    "intervensi_gambars[$keyGambarType][id]",
                                    $intervensiGambarMap[$gambarType->id]['id'] ?? null,
                                ) }}
                                <button type='button' class="preview-change-image btn btn-primary">Pilih Gambar</button>
                            </span>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    @endforeach
</div>