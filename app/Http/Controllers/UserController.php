<?php
	namespace App\Http\Controllers;

	use App\Models\User;
	use App\Models\Cargo;
	use App\Models\Setor;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rule;

	class UserController extends Controller
	{
		// ==============================
		// TELA DE LOGIN
		// ==============================
		public function login()
		{
			return view('auth.login');
		}

		// ==============================
		// PROCESSAR LOGIN
		// ==============================
		public function autenticar(Request $request)
		{
			$dados = $request->validate([
				'email' => 'required|email',
				'password' => 'required'
			]);

			$user = User::where('email', $dados['email'])->first();

			if ($user && Hash::check($dados['password'], $user->password)) {
				// Aqui  pode adicionar sessão e redirecionamento
				session([
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role // <- Salva o tipo na sessão
            ]);
				return redirect()->route('users.index')->with('sucesso', 'Login realizado!');
			}

			return redirect()->back()->with('erro', 'E-mail ou senha inválidos.');
		}

		// ==============================
		// LOGOUT
		// ==============================
		public function logout()
		{
			session()->flush();
			return redirect()->route('login')->with('sucesso', 'Você saiu do sistema!');
		}



		// ==============================
		// CRUD USUÁRIOS
		// ==============================

		// LISTAR TODOS
		public function index()
		{
			$perfil = session('user_role');

			// USUÁRIO COMUM: VAI DIRETO PARA O SEU PERFIL
			if ($perfil === 'user') {
				$meuId = session('user_id');
				return redirect()->route('users.show', $meuId)->with('sucesso', 'Bem-vindo! Aqui estão os seus dados.');
			}

			// Admin e Técnico veem a lista normalmente
			$users = User::with(['cargo', 'setor'])->orderBy('name', 'asc')->get();
			return view('users.index', compact('users'));
		}

		// TELA DE CADASTRO
		public function create()
		{
			
			$cargos = Cargo::orderBy('nome', 'asc')->get();
        	$setores = Setor::orderBy('nome', 'asc')->get();
			return view('users.create', compact('cargos', 'setores'));
		}

		// SALVAR NOVO
		public function store(Request $request)
		{
			$dados = $request->validate([
				'name' => 'required|string|max:255',
				'email' => 'required|email|unique:users,email',
				'password' => 'required|string|min:6',
				'contato'  => 'nullable|string|max:50',
				'endereco' => 'nullable|string|max:255',
				'role'     => ['required', Rule::in(['user', 'technician', 'admin'])],
				'cargo_id' => 'nullable|exists:cargos,id',
				'setor_id' => 'nullable|exists:setores,id'
			]);

			// Criptografar senha
			$dados['password'] = Hash::make($dados['password']);

			User::create($dados);

			return redirect()->route('users.index')->with('sucesso', 'Usuário cadastrado com sucesso!');
		}

		// TELA DE DETALHES
		public function show(User $user)
		{
			$user->load(['cargo', 'setor']);
			return view('users.show', compact('user'));
		}

		// TELA DE EDIÇÃO
		public function edit(User $user)
		{
			$perfil = session('user_role');
			$meuId = session('user_id');

			// Regra Usuário Comum
			if ($perfil === 'user' && $user->id != $meuId) {
				abort(403, 'Você só pode editar seus próprios dados.');
			}

			// Regra Técnico
			if ($perfil === 'technician' && $user->id != $meuId) {
				abort(403, 'Você só tem permissão para alterar o seu cadastro.');
			}

			$cargos = Cargo::orderBy('nome', 'asc')->get();
			$setores = Setor::orderBy('nome', 'asc')->get();
			return view('users.edit', compact('user', 'cargos', 'setores'));
		}
		

		// ATUALIZAR
		public function update(Request $request, User $user)
		{
			$perfil = session('user_role');
			$meuId = session('user_id');

			// Se for Técnico ou Usuário -> REMOVE os campos que ELES NÃO PODEM ALTERAR
			if ($perfil === 'technician' || $perfil === 'user') {
				// Se tentar enviar esses dados, descartamos para não alterar
				$request->offsetUnset('role');
				$request->offsetUnset('cargo_id');
				$request->offsetUnset('setor_id');
			}

			$dados = $request->validate([
				'name'     => 'required|string|max:255',
				'email'    => 'required|email|unique:users,email,'.$user->id,
				'password' => 'nullable|min:6',
				'contato'  => 'nullable|string|max:50',
				'endereco' => 'nullable|string|max:255',
				//Esses campos só são validados se vierem (ou seja, só para admin)
				'role'     => 'nullable|in:admin,technician,user',
				'cargo_id' => 'nullable|exists:cargos,id',
				'setor_id' => 'nullable|exists:setores,id',
			]);

			if(empty($dados['password'])){
				unset($dados['password']);
			} else {
				$dados['password'] = Hash::make($dados['password']);
			}

			$user->update($dados);

			return redirect()->route('users.index')->with('sucesso', 'Dados atualizados com sucesso!');
		}

		// EXCLUIR
		public function destroy(User $user)
		{
			$user->delete();
			return redirect()->route('users.index')->with('sucesso', 'Usuário removido!');
		}
	}

			
