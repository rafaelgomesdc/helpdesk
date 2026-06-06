@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/aberturaChamados.css">
@endpush

@section('content')
    <h1>Abrir Chamado</h1>
    <form action="/" method="GET">
        <div class="formAbrirChamado">
            <div class="select">
                <div class="selectItem">
                    <p>Categoria</p>
                    <select name="categoriaChamado" id="">
                        <option value="">Selecione a categoria</option>
                        @foreach($categorias as $c)
                            <option value={{ $c->nome }}>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="selectItem">
                    <p>Prioridade</p>
                    <select name="prioridade" id="">
                        <option value="">Selecione o nível de prioridade</option>
                        <option value="opcao">opcao</option>
                        <option value="opcao">opcao</option>
                        <option value="opcao">opcao</option>
                    </select>
                </div>
            </div>
            <p>Título</p>
            <input type="text" name="tituloChamado">
            <p>Descrição</p>
            <textarea name="descChamado" id="" cols="30" rows="5"></textarea>
            <p>Anexos</p>
            <div class="anexos" id="anexos">
                <input type="file" name="anexoChamado" id="">
            </div>
            <button type="button" onclick={AdicionarAnexo()} class="btn btn-primary">Adicionar Anexo</button>
            <button class="btn btn-primary">Enviar</button>
        </div>
    </form>

    <script>
        function AdicionarAnexo() {
            let inputFile = document.createElement('input');
            inputFile.type = "file";

            document.getElementById("anexos").appendChild(inputFile);
        }
    </script>
@endsection