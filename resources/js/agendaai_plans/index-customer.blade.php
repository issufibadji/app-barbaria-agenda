@extends('layouts.app')

@push('style')
    <style>
        .single-price-plan {
            border-radius: .75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform .3s, box-shadow .3s;
        }

        .single-price-plan:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .single-price-plan .title h3 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .single-price-plan .line {
            width: 50px;
            height: 4px;
            background-color: #007bff;
            /* azul do mockup */
            border-radius: 2px;
            margin-top: .25rem;
        }

        .single-price-plan .price .display-4 {
            font-size: 3rem;
            color: #d63333;
            /* rosa/pink do preço */
        }

        .single-price-plan ul li i {
            font-size: 1rem;
            vertical-align: middle;
        }

        .single-price-plan .btn {
            padding: .75rem 2rem;
            font-size: 1.1rem;
            border-radius: .5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Planos</h1>
        </div>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h5 class="panel-title">Planos Disponíveis</h5>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i
                            class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                            class="fa fa-minus"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">

                    <!-- Price Plan Area-->
                    <section class="price-plan-area section-padding-130" id="pricing">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-9 col-lg-6">
                                    <!-- Section Heading-->
                                    <div class="section-heading text-center wow fadeInUp">
                                        <h3>Assine já um de nossos planos e otimize seus agendamentos</h3>
                                        <p>A AgendaAi vai te ajudar a marcar e gerenciar o horário de seus clientes, e
                                            disponibilizar
                                            site para ele agendar com você!.</p>
                                        <div class="line"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center g-5">
                                <!-- Single Price Plan Area-->
                                @forelse($plans as $plan)
                                    <div class="col-12 col-sm-9 col-md-7 col-lg-4 mb-4">
                                        <div class="single-price-plan text-center p-4">
                                            <div class="title mb-3">
                                                <h3 class="mb-1">{{ $plan->name }}</h3>
                                                <div class="line mx-auto"></div>
                                            </div>
                                            <div class="price my-4">
                                                <h4 class="display-4 fw-bold">R$
                                                    {{ number_format($plan->price, 2, ',', '.') }}</h4>
                                            </div>
                                            <ul class="list-unstyled text-start px-3 mb-4">
                                                <li class="mb-2"><i class="fa fa-check me-2 text-success"></i> Duração:
                                                    {{ $plan->days }} dia(s)</li>
                                                <li class="mb-2"><i class="fa fa-check me-2 text-success"></i> Melhor plataforma da Internet</li>
                                                <li class="mb-2"><i class="fa fa-check me-2 text-success"></i> Site para agendamentos</li>
                                                <li class="mb-2"><i class="fa fa-check me-2 text-success"></i> Suporte para configurações</li>
                                                <li class="mb-2"><i class="fa fa-check me-2 text-success"></i> {{ \Illuminate\Support\Str::limit($plan->descrition, 120) }}</li>
                                            </ul>
                                            <a href="checkout/{{ $plan->id }}" class="btn btn-success btn-lg">Compre Já</a>
                                        </div>
                                    </div>

                                @empty
                                    <div class="col-12 text-center text-muted">
                                        Nenhum plano cadastrado.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
