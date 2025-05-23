@extends('layout.base')
@section('content')
<div class="w-1/2 mx-auto mt-5">
    <h1 class="text-center">Update Employe</h1>
    <form action="{{ route('subkriteria.update' , $subkriteria->idSubKriteria) }}" method="POST" class="max-w-md mx-auto" enctype="multipart/form-data" data-update-form>
        @csrf
        @method('PUT')
        <!-- firstname -->
        <div class="mb-4">
            <label for="noun" class="block font-medium text-gray-700">Firstname</label>
            <input type="text" name="firstname" id="firstname" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->firstname }}">
            @error('firstname')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <!-- lastname -->
        <div class="mb-4">
            <label for="noun" class="block font-medium text-gray-700">lastname</label>
            <input type="text" name="lastname" id="lastname" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->lastname }}">
            @error('lastname')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <!-- email -->

        <div class="mb-4">
            <label for="quantity" class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->email }}">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


         <!-- address -->
        <div class="mb-4">
            <label for="price" class="block font-medium text-gray-700">Address</label>
            <input type="text" name="address" id="address" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->address }}">
            @error('address')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- phone -->
        <div class="mb-4">
            <label for="phone" class="block font-medium text-gray-700">Phone</label>
            <input type="tel" name="phone" id="phone" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->phone }}">
            @error('phone')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <!-- image -->
        <div class="mb-4">
            <label for="image" class="block font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="border-gray-300 py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md shadow-sm p-2" value="{{ $Employe->image }}">
            <img src="/images/{{$Employe->image}}" alt="employe image" srcset="">
        </div>
        @error('image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror


        <div class="mb-4">
            <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600">Update Employe</button>
        </div>
        <div>
            <a href="{{ url('/employes') }}" class="text-blue-500 p-2">Back</a>
        </div>
    </form>
</div>


@stop
