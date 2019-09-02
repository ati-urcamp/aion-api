<html>
<head>
    <meta charset="UTF-8">
    <title>Tarefas por período</title>
    <style type="text/css">
        .header,
        .header-table {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            width: 100%;
        }

        .header-title {
            font-size: 20px;
            font-weight: bold;
        }

        .footer,
        .footer-table {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            width: 100%;
        }

        .registros-header {
            background-color: #F8F8F8;
            border: 1px solid #DDD;
            border-bottom: none;
            padding: 5px 10px;
            width: 100%;
        }

        .registros-header-title,
        .registros-table-footer-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            font-weight: bold;
            margin: 0;
        }

        .registros-header-text {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        .registros-table {
            border: 1px solid #DDD;
            border-collapse: collapse;
            width: 100%;
        }

        .registros-table th,
        .registros-table td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
            padding: 5px 10px;
            border: 1px solid #DDD;
            text-align: left;
        }

        .registros-table th {
            background-color: #F8F8F8;
            font-weight: bold;
        }

        .registros-table-footer td {
            background-color: #F8F8F8;
        }

        .mt24 {
            margin-top: 24px;
        }
    </style>
</head>
<body>
<htmlpagefooter name="pagefooter">
    <div class="footer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="footer-table">
            <tr>
                <td align="left" valign="top">Gerado em {DATE d/m/Y \à\s H:i}</td>
                <td align="right" valign="top">Página {PAGENO} de {nbpg}</td>
            </tr>
        </table>
    </div>
</htmlpagefooter>
<sethtmlpagefooter name="pagefooter" page="all" value="on"></sethtmlpagefooter>

@foreach ($projetos as $projeto)
    <htmlpageheader name="pageheader-{{ $projeto['id'] }}">
        <div class="header">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="header-table">
                <tr>
                    <td align="left" valign="bottom">
                        <h1 class="header-title">{{ $projeto['nome'] }}</h1>
                        <p class="header-text">
                            <strong>{{ $projeto['cliente'] }}</strong> -
                            Responsável: {{ $projeto['responsavel'] }}
                        </p>
                    </td>
                    <td align="right" valign="bottom">
                        <strong>Período:</strong><br>
                        {{ dateEnToBr($dt_inicial) }} à {{ dateEnToBr($dt_final) }}
                    </td>
                </tr>
            </table>
        </div>
    </htmlpageheader>
    <sethtmlpageheader name="pageheader-{{ $projeto['id'] }}"
                       page="all" value="on" show-this-page="1"></sethtmlpageheader>

    <div class="registros-header">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="registros-header-table">
            <tr>
                <td align="left" valign="middle">
                    <h2 class="registros-header-title">
                        Feitas no período
                    </h2>
                </td>
                <td align="right" valign="middle" class="registros-header-text">
                    <strong>{{ count($projeto['tarefas']) }}</strong> {{ count($projeto['tarefas']) > 1 ? 'tarefas' : 'tarefa' }}
                </td>
            </tr>
        </table>
    </div>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="registros-table">
        <tr>
            <th>Tarefa</th>
            <th>Situação</th>
            <th>Criada em</th>
            <th>Trabalhado</th>
            <th>Valor</th>
        </tr>

        @foreach ($projeto['tarefas'] as $tarefa)
            <tr>
                <td>{{ $tarefa['titulo'] }} ({{ $tarefa['tipo'] }})</td>
                <td>{{ $tarefa['situacao'] }}</td>
                <td>{{ dateEnToBr($tarefa['dt_criacao']) }}</td>
                <td>{{ $tarefa['total_periodo_humanizado'] }}</td>
                <td>R$ {{ currencyEnToBr($tarefa['valor_periodo']) }}</td>
            </tr>
        @endforeach

        <tr class="registros-table-footer">
            <td colspan="3" align="right">
                <strong>Período:</strong>
            </td>
            <td>{{ $projeto['total_periodo_humanizado'] }}</td>
            <td>R$ {{ currencyEnToBr($projeto['valor_periodo']) }}</td>
        </tr>

        <tr class="registros-table-footer">
            <td colspan="3" align="right">
                <strong>Períodos anteriores:</strong>
            </td>
            <td>{{ $projeto['total_anteriores_humanizado'] }}</td>
            <td>R$ {{ currencyEnToBr($projeto['valor_anteriores']) }}</td>
        </tr>

        <tr class="registros-table-footer">
            <td colspan="3" align="right">
                <strong>Total:</strong>
            </td>
            <td>{{ $projeto['total_geral_humanizado'] }}</td>
            <td>R$ {{ currencyEnToBr($projeto['valor_geral']) }}</td>
        </tr>
    </table>

    @if(count($projeto['proximas_tarefas']) > 0)
        <div class="registros-header mt24">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="registros-header-table">
                <tr>
                    <td align="left" valign="middle">
                        <h2 class="registros-header-title">
                            Próximas atividades
                        </h2>
                    </td>
                    <td align="right" valign="middle" class="registros-header-text">
                        <strong>{{ count($projeto['proximas_tarefas']) }}</strong> {{ count($projeto['proximas_tarefas']) > 1 ? 'tarefas' : 'tarefa' }}
                    </td>
                </tr>
            </table>
        </div>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="registros-table">
            <thead>
            <tr>
                <th>Tarefa</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($projeto['proximas_tarefas'] as $tarefa)
                <tr>
                    <td>{{ $tarefa->titulo }} ({{ $tarefa->tarefa_tipo }})</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if(!$loop->last)
        <pagebreak resetpagenum="1"></pagebreak>
    @endif
@endforeach
</body>
</html>
