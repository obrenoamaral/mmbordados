<x-app-layout>

    <div class="flex justify-center items-center w-full h-screen">
        <div >
            <div class="flex justify-between">
                <h1 class="text-2xl font-bold">Tabela de bordados</h1>

                <!-- Campo de busca -->
                <form method="GET" action="{{ route('bordados.index') }}" class="mb-4">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            value="{{ old('search', $search) }}"
                            class="form-control rounded border p-2"
                            placeholder="Buscar por nome">
                        <button type="submit" class="btn btn-primary px-6 py-2 bg-blue-300 hover:bg-blue-500 rounded text-white">Buscar</button>
                    </div>
                </form>
            </div>

            <!-- Tabela de bordados -->
            <table class="table-auto w-full border-collapse border border-gray-300 shadow-lg rounded-lg overflow-hidden">
                <!-- Cabeçalho -->
                <thead>
                <tr class="bg-blue-300 text-white text-left">
                    <th class="px-4 py-2 first:rounded-tl-lg w-40">ID</th>
                    <th class="px-4 py-2 w-72">Nome</th>
                    <th class="px-4 py-2 w-40">Preço</th>
                    <th class="px-4 py-2 w-40">Local</th>
                    <th class="px-4 py-2 last:rounded-tr-lg w-52">Ações</th>
                </tr>
                </thead>

                <!-- Corpo -->
                <tbody class="bg-white">
                @forelse($bordados as $bordado)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="px-4 py-2 text-left">{{ $bordado->id }}</td>
                        <td class="px-4 py-2 text-left">{{ $bordado->nome }}</td>
                        <td class="px-4 py-2 text-left">{{ $bordado->preco }}</td>
                        <td class="px-4 py-2 text-left">{{ $bordado->local }}</td>
                        <td class="px-4 py-2 flex space-x-2">
                            <!-- Botão Editar -->
                            <button
                                onclick="openEditModal({{ $bordado }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>

                            </button>

                            <!-- Botão Excluir -->
                            <form action="{{ route('bordados.destroy', $bordado->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este bordado?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Nenhum bordado encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="flex justify-end">
                <button id="openModal" class="bg-blue-300 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 mt-4">
                    Adicionar Bordado
                </button>
            </div>


            <!-- Modal -->
            <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold">Adicionar Bordado</h2>
                        <button id="closeModal" class="text-gray-500 hover:text-gray-800 font-bold text-xl">&times;</button>
                    </div>

                    <form action="{{ route('bordados.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="Nome"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="preco" class="block text-sm font-medium text-gray-700">Preço</label>
                            <input type="number" id="preco" step="0.01" name="preco" placeholder="Preço"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="local" class="block text-sm font-medium text-gray-700">Local</label>
                            <input type="text" id="local" name="local" placeholder="Local"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-500" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-300 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal de Edição -->
            <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold">Editar Bordado</h2>
                        <button id="closeEditModal" class="text-gray-500 hover:text-gray-800 font-bold text-xl">&times;</button>
                    </div>

                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="editNome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="editNome" name="nome" placeholder="Nome"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="editPreco" class="block text-sm font-medium text-gray-700">Preço</label>
                            <input type="number" id="editPreco" step="0.01" name="preco" placeholder="Preço"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="editLocal" class="block text-sm font-medium text-gray-700">Local</label>
                            <input type="text" id="editLocal" name="local" placeholder="Local"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>



            <!-- Links de paginação -->
            {{ $bordados->withQueryString()->links() }}
        </div>
    </div>

    <script>
        // Referências aos elementos do modal
        const openModalBtn = document.getElementById('openModal');
        const closeModalBtn = document.getElementById('closeModal');
        const modal = document.getElementById('modal');

        // Abrir modal
        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Fechar modal
        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Fechar modal ao clicar fora do conteúdo
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>

    <script>
        const editModal = document.getElementById('editModal');
        const closeEditModalBtn = document.getElementById('closeEditModal');
        const editForm = document.getElementById('editForm');

        // Abrir o modal e preencher os campos
        function openEditModal(bordado) {
            editModal.classList.remove('hidden');
            document.getElementById('editNome').value = bordado.nome;
            document.getElementById('editPreco').value = bordado.preco;
            document.getElementById('editLocal').value = bordado.local;
            editForm.action = `/bordados/update/${bordado.id}`;
        }

        // Fechar o modal
        closeEditModalBtn.addEventListener('click', () => {
            editModal.classList.add('hidden');
        });

    </script>

</x-app-layout>
