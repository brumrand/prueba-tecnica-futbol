import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\FavoriteTeamController::store
* @see app/Http/Controllers/FavoriteTeamController.php:23
* @route '/favorite-teams/{teamId}'
*/
export const store = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/favorite-teams/{teamId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\FavoriteTeamController::store
* @see app/Http/Controllers/FavoriteTeamController.php:23
* @route '/favorite-teams/{teamId}'
*/
store.url = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { teamId: args }
    }

    if (Array.isArray(args)) {
        args = {
            teamId: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        teamId: args.teamId,
    }

    return store.definition.url
            .replace('{teamId}', parsedArgs.teamId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FavoriteTeamController::store
* @see app/Http/Controllers/FavoriteTeamController.php:23
* @route '/favorite-teams/{teamId}'
*/
store.post = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FavoriteTeamController::store
* @see app/Http/Controllers/FavoriteTeamController.php:23
* @route '/favorite-teams/{teamId}'
*/
const storeForm = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FavoriteTeamController::store
* @see app/Http/Controllers/FavoriteTeamController.php:23
* @route '/favorite-teams/{teamId}'
*/
storeForm.post = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(args, options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\FavoriteTeamController::destroy
* @see app/Http/Controllers/FavoriteTeamController.php:15
* @route '/favorite-teams/{teamId}'
*/
export const destroy = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/favorite-teams/{teamId}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\FavoriteTeamController::destroy
* @see app/Http/Controllers/FavoriteTeamController.php:15
* @route '/favorite-teams/{teamId}'
*/
destroy.url = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { teamId: args }
    }

    if (Array.isArray(args)) {
        args = {
            teamId: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        teamId: args.teamId,
    }

    return destroy.definition.url
            .replace('{teamId}', parsedArgs.teamId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FavoriteTeamController::destroy
* @see app/Http/Controllers/FavoriteTeamController.php:15
* @route '/favorite-teams/{teamId}'
*/
destroy.delete = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\FavoriteTeamController::destroy
* @see app/Http/Controllers/FavoriteTeamController.php:15
* @route '/favorite-teams/{teamId}'
*/
const destroyForm = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FavoriteTeamController::destroy
* @see app/Http/Controllers/FavoriteTeamController.php:15
* @route '/favorite-teams/{teamId}'
*/
destroyForm.delete = (args: { teamId: string | number } | [teamId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const favoriteTeams = {
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
}

export default favoriteTeams