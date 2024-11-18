@extends('admin.layouts.main')

@push('header')
    <title>Create Transaction</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Transaction Create</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Transaction</li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title">{{ $title }}</h5>
                        </div>

                          <!-- Multi Columns Form -->
                        <form method="post" action="{{ route($url, ['id'=>$id])}}" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" class="form-control"
                                id="payment_date" name="payment_date"
                                value="{{ old('payment_date') ?? '' }}">
                            @error('payment_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-4">
                            <label for="reciept_token" class="form-label">Reciept Token</label>
                            <input type="text" class="form-control"
                                id="reciept_token" name="reciept_token"
                                value="{{ old('reciept_token') ?? '' }}">
                            @error('reciept_token')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-4">
                            <label for="paid_amount" class="form-label">Paid Amount</label>
                            <input type="number" class="form-control"
                                id="paid_amount" name="paid_amount"
                                value="{{ old('paid_amount') ?? '' }}">
                            @error('paid_amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>

                            <div class="col-md-4">
                            <label for="reciept_file" class="form-label">Reciept File</label>
                            <input type="file" accept="image/*" class="form-control" id="reciept_file" name="reciept_file"
                                value="{{ old('reciept_file') ?? '' }}">
                            @error('reciept_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>

                            <fieldset class="col-md-8">
                                <legend class="pt-0 col-form-label col-md-12">Payment Type</legend>
                                <div class="col-md-12">
                                    {{-- 'dd', 'cash', 'cheque', 'bank transfer', 'nft', 'upi' --}}
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type1" value="dd" checked="">
                                              <label class="form-check-label" for="pay_type1">
                                                DD
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type2" value="cash">
                                              <label class="form-check-label" for="pay_type2">
                                                  Cash
                                              </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check disabled">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type3" value="cheque">
                                              <label class="form-check-label" for="pay_type3">
                                                  Cheque
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type4" value="bank transfer">
                                              <label class="form-check-label" for="pay_type4">
                                                Bank Transfer
                                              </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type5" value="nft">
                                              <label class="form-check-label" for="pay_type5">
                                                NFT
                                              </label>
                                            </div>
                                            <div class="form-check disabled">
                                              <input class="form-check-input" type="radio" name="pay_type" id="pay_type6" value="upi">
                                              <label class="form-check-label" for="pay_type6">
                                                    UPI
                                              </label>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                              </fieldset>

                            <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
