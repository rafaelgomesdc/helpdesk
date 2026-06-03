@extends('layouts.main')

@section('content')
    <h1>Abrir Chamado</h1>
    <form action="/" method="GET">
        <div class="formAbrirChamado">
            <select name="categoriaChamado" id="">
                <option value="">Selecione a categoria</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
            </select>
            <select name="prioridade" id="">
                <option value="">Selecione o nível de prioridade</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
                <option value="opcao">opcao</option>
            </select>
            <input type="text" name="tituloChamado">
            <input type="text" name="descChamado">
            <div class="anexos" id="anexos">
                <input type="file" name="anexoChamado" id="">
            </div>
            <button type="button" onclick={AdicionarAnexo()}>Adicionar Anexo</button>
            <input type="submit" name="enviar">
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