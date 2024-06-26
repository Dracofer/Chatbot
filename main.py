import re

# Define o nome do arquivo onde as respostas serão salvas
ARQUIVO_RESPOSTAS = 'respostas.txt'

# Verifica se o arquivo existe e cria um novo se não existir
try:
    with open(ARQUIVO_RESPOSTAS, 'r') as f:
        respostas = eval(f.read())
except FileNotFoundError:
    respostas = {}

print('''Escreva o Suporte desejado!
1 - Contratar Internet
2 - Problemas com Internet
3 - Segunda via Boleto
4 - Financeiro
5 - Finalizar atendimento
6 - Ouvidoria''')

# Função para adicionar novas respostas
def adicionar_resposta():
    padrao = input("Digite o padrão de entrada: ")
    resposta = input("Digite a resposta correspondente: ")
    respostas[padrao] = resposta
    print("Nova resposta adicionada com sucesso!")

    # Salva as respostas atualizadas no arquivo
    with open(ARQUIVO_RESPOSTAS, 'w') as f:
        f.write(str(respostas))

# Loop principal do chatbot
while True:
    # Lê a entrada do usuário
    entrada = input("> ")

    # Verifica se a entrada corresponde a algum padrão de entrada conhecido
    for padrao, resposta in respostas.items():
        if re.match(padrao, entrada, re.IGNORECASE):
            print(resposta)
            break
    else:
        # Verifica se o usuário deseja encerrar o chatbot
        if entrada.lower() == 'tchau':
            print("Tchau! Até logo.")

            # Salva as respostas atualizadas no arquivo antes de encerrar
            with open(ARQUIVO_RESPOSTAS, 'w') as f:
                f.write(str(respostas))

            break
        else:
            print("Desculpe, eu não entendi o que você quis dizer.")

            # Pergunta ao usuário se deseja adicionar uma nova resposta
            resposta = input("Escolha uma das opções.")
            if resposta.lower() == 'sim':
                adicionar_resposta()
