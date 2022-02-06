{{$team->name}}
{{$team->shortName}}
{{$team->area->name}}
@foreach($team->squad as $squad)
    <div>
        <div>
            {{$squad->name}}
        </div>
        <div>
            {{$squad->position}}
        </div>
    </div>
@endforeach
area": {#426 ▼
    +"id": 2088
    +"name": "Germany"
  }
  +"activeCompetitions": array:2 [▶]
  +"name": "VfB Stuttgart"
  +"shortName": "Stuttgart"
  +"tla": "VFB"
  +"crestUrl": "https://crests.football-data.org/10.svg"
  +"address": "Mercedesstraße 109 Stuttgart 70372"
  +"phone": "+49 (1805) 832 5463"
  +"website": "http://www.vfb.de"
  +"email": "info@vfb-stuttgart.de"
  +"founded": 1893
  +"clubColors": "White / Red"
  +"venue": "Mercedes-Benz Arena"
  +"squad": array:33 [▼
    0 => {#412 ▼
      +"id": 190
      +"name": "Nikolas Nartey"
      +"position": "Defender"
      +"dateOfBirth": "2000-02-22T00:00:00Z"
      +"countryOfBirth": "Denmark"
      +"nationality": "Denmark"
      +"shirtNumber": null
      +"role": "PLAYER"
    }