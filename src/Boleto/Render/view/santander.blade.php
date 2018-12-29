@extends('BoletoHtmlRender::layout')
@section('boleto')
	<style>
	body > div:first-child { margin: 0 auto; }
	.barcode { height: 60px;}
	.table-boleto .conteudo { font-size: 8pt;}
	</style>
    @foreach($boletos as $i => $boleto)
        @php extract($boleto, EXTR_OVERWRITE); @endphp
        @if($mostrar_instrucoes)
            <div class="noprint info">
                <h2>Instruções de Impressão</h2>
                <ul>
                    @forelse ($instrucoes_impressao as $instrucao_impressao)
                        <li>{{ $instrucao_impressao }}</li>
                    @empty

                        <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use
                            modo econômico).
                        </li>
                        <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à
                            direita do formulário.
                        </li>
                        <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o
                            código de barras.
                        </li>
                        <li>Caso não apareça o código de barras no final, pressione F5 para atualizar esta tela.</li>
                        <li>Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa
                            eletrônico ou no internet banking:
                        </li>
                    @endforelse
                </ul>
                <span class="header">Linha Digitável: {{ $linha_digitavel }}</span>
                <span class="header">Número: {{ $numero }}</span>
                {!! $valor ? '<span class="header">Valor: R$' . $valor . '</span>' : '' !!}
                <br>
            </div>
        @endif

		<!--
        <div class="linha-pontilhada" style="margin-bottom: 20px;">Recibo do pagador</div>
        <div class="info-empresa">
            @if ($logo)
                <div style="display: inline-block;">
                    <img alt="logo" src="{{ $logo_base64 }}"/>
                </div>
            @endif
            <div style="display: inline-block; vertical-align: super;">
                <div><strong>{{ $beneficiario['nome'] }}</strong></div>
                <div>{{ $beneficiario['documento'] }}</div>
                <div>{{ $beneficiario['endereco'] }}</div>
                <div>{{ $beneficiario['endereco2'] }}</div>
            </div>
        </div>
        <br>
-->
        <table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <tr>
                <td valign="bottom" colspan="8" class="noborder nopadding">
                    <div class="logocontainer">
                        <div class="logobanco">
                            <img style="width: 35mm; padding: .7mm;" src="{{ isset($logo_banco_base64) && !empty($logo_banco_base64) ? $logo_banco_base64 : 'https://dummyimage.com/150x75/fff/000000.jpg&text=+' }}" alt="logo do banco">
                        </div>
                        <div class="codbanco">{{ $codigo_banco_com_dv }}</div>
                    </div>
					<!--<div class="linha-digitavel">{{ $linha_digitavel }}</div> -->
					<div class="linha-digitavel" style="">RECIBO DO PAGADOR</div>
                </td>
            </tr>
			<tr>
				<td colspan="7" class="top-2">
					<div class="titulo">Local de pagamento</div>
					<div class="conteudo">{{ $local_pagamento }}</div>
				</td>
				<td width="180" class="top-2">
					<div class="titulo">Vencimento</div>
					<div class="conteudo rtl" style="font-size: 10pt; padding-bottom: 3px">{{ $data_vencimento->format('d/m/Y') }}</div>
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<div class="titulo">Beneficiário</div>
					<div class="conteudo">{{ $beneficiario['nome_documento'] }}</div>
					<div class="conteudo">{{ $beneficiario['endereco'] }} - {{ $beneficiario['endereco2'] }}</div>
				</td>
				<td>
					<div class="titulo">Agência/Código beneficiário</div>
					<div class="conteudo rtl">{{ $agencia_codigo_beneficiario }}</div>
				</td>
			</tr>
			<tr>
				<td width="110" colspan="2">
					<div class="titulo">Data do documento</div>
					<div class="conteudo">{{ $data_documento->format('d/m/Y') }}</div>
				</td>
				<td width="120" colspan="2">
					<div class="titulo">Nº documento</div>
					<div class="conteudo">{{ $numero_documento }}</div>
				</td>
				<td width="60">
					<div class="titulo">Espécie doc.</div>
					<div class="conteudo">{{ $especie_doc }}</div>
				</td>
				<td>
					<div class="titulo">Aceite</div>
					<div class="conteudo">{{ $aceite }}</div>
				</td>
				<td width="110">
					<div class="titulo">Data processamento</div>
					<div class="conteudo">{{ $data_processamento->format('d/m/Y') }}</div>
				</td>
				<td>
					<div class="titulo">Nosso número</div>
					<div class="conteudo rtl">{{ $nosso_numero_boleto }}</div>
				</td>
			</tr>
			<tr>
				@if(!isset($esconde_uso_banco) || !$esconde_uso_banco)
					<td {{ !isset($mostra_cip) || !$mostra_cip ? 'colspan=2' : ''}}>
						<div class="titulo">Uso do banco</div>
						<div class="conteudo">{{ $uso_banco }}</div>
					</td>
					@endif
					@if (isset($mostra_cip) && $mostra_cip)
							<!-- Campo exclusivo do Bradesco -->
					<td width="20">
						<div class="titulo">CIP</div>
						<div class="conteudo">{{ $cip }}</div>
					</td>
				@endif

				<td {{isset($esconde_uso_banco) && $esconde_uso_banco ? 'colspan=3': '' }}>
					<div class="titulo">Carteira</div>
					<div class="conteudo">{{ $carteira_nome }}</div>
				</td>
				<td width="35">
					<div class="titulo">Espécie</div>
					<div class="conteudo">{{ $especie }}</div>
				</td>
				<td colspan="2">
					<div class="titulo">Quantidade</div>
					<div class="conteudo"></div>
				</td>
				<td width="110">
					<div class="titulo">Valor</div>
					<div class="conteudo"></div>
				</td>
				<td>
					<div class="titulo">(=) Valor do Documento</div>
					<div class="conteudo rtl" style="font-size:10pt; padding-bottom:2px">{{ $valor }}</div>
				</td>
			</tr>

			<tr>
				<td colspan="7">
					<div class="titulo">Pagador:</div>
					<div class="conteudo">{{ $pagador['nome_documento'] }}</div>
					<div class="conteudo">{{ $pagador['endereco'] }}</div>
					<div class="conteudo">{{ $pagador['endereco2'] }}</div>
				</td>
				<td class="noleftborder" style="vertical-align:top">
					
				</td>
			</tr>

			<tr>
				<td colspan="7" class="notopborder">
					<div class="titulo">Sacador/Avalista:
						<div class="conteudo sacador">{{ $sacador_avalista ? $sacador_avalista['nome_documento'] : '' }}</div>
					</div>
				</td>
				<td class="notopborder noleftborder">
					<div>Código de Baixa</div>
				</td>
			</tr>




            <tr>
				<td colspan="8" class="top-2 conteudo" style="height: 6.5cm; vertical-align:top; font-weight:normal;">
                    <p style="margin-top: 10px">{{ $demonstrativo[0] }}</p>
                    <p>{{ $demonstrativo[1] }}</p>
                    <p>{{ $demonstrativo[2] }}</p>
                    <p>{{ $demonstrativo[3] }}</p>
					<div style="margin-bottom: 10px;">{{ $demonstrativo[4] }}</div>
                </td>
			</tr>
			<tr>
				<td colspan="7" class="noleftborder"></td>
				<td class="noleftborder norightborder" colspan="8">
                    <div class="titulo" style="text-align:center; height: 1.3cm">Autenticação mecânica</div>
                </td>
			</tr>
            </tbody>
        </table>
        <br>
        <div class="linha-pontilhada">Corte na linha pontilhada</div>
        <br>

        <!-- Ficha de compensação -->
        @include('BoletoHtmlRender::partials/santander-ficha-compensacao')

        @if(count($boletos) > 1 && count($boletos)-1 != $i)
            <div style="page-break-before:always"></div>
        @endif
    @endforeach
@endsection
