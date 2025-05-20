@if($next)
    <input type="hidden" name="next_route" value="{{route("installer.{$next['url']}")}}">
@else
    <input type="hidden" name="next_route" value="{{url($finish_url)}}">
@endif

<div class="w-100 d-flex justify-content-between">
    <div>
        @if($previous)
            <a href="{{ $previous['url'] == '' ? '/installer' : route("installer.{$previous['url']}") }}"
               class="btn btn-secondary"><i class="bi bi-arrow-left-square-fill"></i> Prev</a>
        @endif
    </div>
    <div>
        @if($can_skip)
            @if($next)
                <a class="btn btn-link" href="{{ route("installer.{$next['url']}")}}">Skip</a>
            @else
                <a class="btn btn-link" href="{{url($finish_url)}}">Skip</a>
            @endif
        @endif
        <button type="submit" class="btn btn-primary">{{$next ? 'Next' : 'Finish'}} <i
                class="bi bi-arrow-right-square-fill"></i></button>
    </div>
</div>
