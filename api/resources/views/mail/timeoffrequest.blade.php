<div>
   
    <div class=""> {{$data->user->fistname . " " . $data->user->lastname}} request for {{$data->type->name}} leave</div>
    <div class="flex w-full justify-center" >

        @component('mail::button', ['url' => $url, 'color' => 'success'])
        View Details
        @endcomponent
        {{-- <a href="localhost:3000"><button class="details">Show Details</button> </a></div> --}}
</div>

<style>
    .details {
        padding: 10px;
        margin-top: 20px;
        background: #2563eb;
        color: white;
        border-radius: 5px;
        border: none;
    }
    .flex {
        display: flex;
    }
    .w-full {
        width: 100%
    }
    .justify-center {
        justify-content: center
    }
</style>