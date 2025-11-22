<x-term::layouts.master>
      <x-header headline="Your Timetable for {{ \Carbon\Carbon::parse($start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($end)->format('d.m.Y') }}">
 <x-slot:actions>
            <x-button href="{{ route('timetable.index', ['date' => $prevWeek]) }}" rounded="rounded-s-lg" variant="default">
               <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14 8-4 4 4 4"/>
                </svg>

               Previous Week
            </x-button>
            <x-button href="{{ route('timetable.index', ['date' => $nextWeek]) }}" variant="default" rounded="rounded-r-lg">

              Next Week
              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
</svg>

            </x-button>
        </x-slot:actions>
      </x-header>
<div class="grid w-full grid-cols-8 text-sm text-center rounded-lg grid-auto-rows rtl:text-center">
    <div class="p-6 font-medium text-white uppercase border border-gray-300 dark:bg-gray-700">Hours\Days</div>
    @foreach($weekDays as $day => $termsForDay)
        <div class="p-6 font-medium text-white uppercase border border-gray-300 dark:bg-gray-700">
            {{ ucfirst($day) }}
        </div>
    @endforeach
    @foreach($hours as $hour)
        <div class="flex items-center justify-center p-2 text-lg font-medium text-white border border-gray-400 dark:bg-gray-800">
            {{ $hour }}:00
        </div>
        @foreach($weekDays as $day => $termsForDay)
            <div class="border border-gray-400 p-1 min-h-[55px] dark:bg-gray-800 dark:hover:bg-gray-700 ">
                    @foreach($termsForDay as $term)
                    @php
                        $startHour = $term->start_at->hour;
                        $startMinute = $term->start_at->minute;

                        $endHour = $term->end_at->hour;
                        $endMinute = $term->end_at->minute;

                        $startInMinutes = $term->start_at->hour * 60 + $term->start_at->minute;
                        $endInMinutes   = $term->end_at->hour * 60 + $term->end_at->minute;

                        $blockStart = $hour * 60;
                        $blockEnd = ($hour + 1) * 60;

                        $overlapStart = max($startInMinutes, $blockStart);
                        $overlapEnd   = min($endInMinutes, $blockEnd);

                        $overlap = max(0, $overlapEnd - $overlapStart);

                        $pxPerMin = 0.9;
                        $height =  $overlap * $pxPerMin;
                        $top = 0;
                        if($height < 30){
                            $top = 45 - $height;
                        }

                        // $height = ($endInMinutes - $startInMinutes) * $pxPerMin;

                        switch($term->type) {
                            case 'lecture':
                                $color = 'bg-blue-600 text-white';
                                break;
                            case 'exercise':
                                $color = 'bg-green-600 text-white';
                                break;
                            case 'exam':
                                $color = 'bg-red-700 text-white';
                                break;
                            case 'assignment':
                                $color = 'bg-yellow-600 text-black';
                                break;
                            default:
                                $color = 'bg-gray-300 text-black';
                        }
                    @endphp

                    @if ($endInMinutes > $blockStart && $startInMinutes < $blockEnd)
                    @if($overlap > 0)
                    {{-- @php      dd($top);@endphp --}}
                         <a href="{{ route('term.show', $term->id) }}">
                        <div class="bg-blue-500 {{ $color }} rounded-md justify-center flex items-center relative group"style="top: {{ $top }}px; height: {{ $height }}px;">
                            {{ $term->name }}
                                <div class="absolute z-50 flex items-center justify-center gap-4 p-2 text-sm text-white transition-opacity transform -translate-x-1/2 -translate-y-full bg-gray-800 rounded-md opacity-0 pointer-events-none left-1/2 min-w-max whitespace-nowrap group-hover:opacity-100">
                                    <span>{{ $term->start_at->format('H:i') }} - {{ $term->end_at->format('H:i') }}</span>
                                </div>
                        </div>
                         </a>
                          @endif
                    @endif
@endforeach
            </div>
        @endforeach
    @endforeach
</div>
</x-term::layouts.master>
