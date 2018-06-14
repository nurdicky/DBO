@extends('layouts.master')

@section('title', 'Data Mobil')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-car"></i>
    </span>
    Data Mobil
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('car.create') }}" class="btn btn-outline-primary">Tambah Data</a>
      </li>
    </ul>
  </nav>    
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Mobil</th>
              <th>Jenis Mobil</th>
              <th >Plat Mobil</th>
              <th>Nomor Rangka</th>
              <th>Nomor Mesin</th>
              <th>Rute</th>
              <th>Pemilik</th>
              <th>Pengemudi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
              @if(count($cars) == 0)
              <tr>
                <td colspan="10">Data Masih Kosong</td>
              </tr>
            @else
              <?php $index=1; ?>
              @foreach($cars as $car)
                <tr>
                  <td>{{ $index++ }}</td>
                  <td class="py-1">
                    <img src="{{ $car->car_image }}" alt="image"/>
                  </td>
                  <td>{{ $car->car_type }}</td>
                  <td>{{ $car->car_plat_number }}</td>
                  <td>{{ $car->car_frame_number }}</td>
                  <td>{{ $car->car_machine_number }}</td>
                  <td>{{ $car->car_rute }}</td>
                  <td>{{ $car->owners->owner_name }}</td>
                  <td>{{ $car->driver_id }}</td>
                  <td>
                    <form action="{{ route('car.destroy', $car->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a class="btn btn-sm btn-info" href="{{ route('car.edit', $car->id) }}">Edit</a>
                      <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('custom_js')

@endsection
