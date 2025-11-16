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
        <div class="p-2 text-lg font-medium text-white border border-gray-400 dark:bg-gray-800">
            {{ $hour }}:00
        </div>
        @foreach($weekDays as $day => $termsForDay)
            <div class="border border-gray-400 p-2 min-h-[50px] dark:bg-gray-800 dark:hover:bg-gray-700 ">
                    @foreach($termsForDay as $term)
                    @php
                        $startHour = (int) $term->start_at->format('H');
                        $endHour = (int) $term->end_at->format('H');

                        switch($term->type) {
                            case 'lecture':
                                $color = 'bg-blue-600 text-white';
                                break;
                            case 'exercise':
                                $color = 'bg-green-600 text-white';
                                break;
                            case 'exam':
                                $color = 'bg-red-600 text-white';
                                break;
                            case 'assignment':
                                $color = 'bg-yellow-600 text-black';
                                break;
                            default:
                                $color = 'bg-gray-300 text-black';
                        }
                    @endphp

                    @if($hour >= $startHour && $hour < $endHour)
                         <a href="{{ route('term.show', $term->id) }}">
                        <div class="p-2  bg-blue-500 {{ $color }} rounded-md">
                            {{ $term->name }}
                        </div>
                         </a>
                    @endif
@endforeach
            </div>
        @endforeach
    @endforeach
</div>
</x-term::layouts.master>
