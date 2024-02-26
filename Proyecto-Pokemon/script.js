const pokemonContainer = document.getElementById('pokemon-container');
const pokemonInfo = document.getElementById('pokemon-info');

async function fetchRandomPokemons() {
    const randomIndices = Array.from({ length: 10 }, () => Math.floor(Math.random() * 898) + 1);
    const responses = await Promise.all(randomIndices.map(index =>
        fetch(`https://pokeapi.co/api/v2/pokemon/${index}`).then(response => response.json())
    ));
    displayPokemons(responses);
}

function displayPokemons(pokemons) {
    pokemonContainer.innerHTML = '';
    pokemons.forEach(pokemon => {
        const pokemonCard = createPokemonCard(pokemon);
        pokemonCard.addEventListener('click', () => displayPokemonInfo(pokemon));
        pokemonContainer.appendChild(pokemonCard);
    });
}

function createPokemonCard(pokemon) {
    const card = document.createElement('div');
    card.classList.add('pokemon-card');
    card.innerHTML = `
        <img class="pokemon-image" src="${pokemon.sprites.front_default}" alt="${pokemon.name}">
        <p class="pokemon-name">${pokemon.name}</p>
    `;
    return card;
}

function displayPokemonInfo(pokemon) {
    const info = `
    <div class="pokemon-info">
    <img class="pokemon-image" src="${pokemon.sprites.front_default}" alt="${pokemon.name}">
    <div class="pokemon-details">
        <h2 class="pokemon-name">${pokemon.name}</h2>
        <p><strong>Altura:</strong> ${pokemon.height / 10} m</p>
        <p><strong>Peso:</strong> ${pokemon.weight / 10} kg</p>
        <p><strong>Tipos:</strong> ${pokemon.types.map(type => type.type.name).join(', ')}</p>
        <p><strong>Estadísticas:</strong></p>
        <ul>
            ${pokemon.stats.map(stat => `<li>${stat.stat.name}: ${stat.base_stat}</li>`).join('')}
        </ul>
        <p><strong>Habilidades:</strong></p>
        <ul>
            ${pokemon.abilities.map(ability => `<li>${ability.ability.name}</li>`).join('')}
        </ul>
    </div>
</div>`;
    pokemonInfo.innerHTML = info;
}

fetchRandomPokemons();
