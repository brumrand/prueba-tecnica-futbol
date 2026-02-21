import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
export const searchByName = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchByName.url(options),
    method: 'get',
})

searchByName.definition = {
    methods: ["get","head"],
    url: '/search-by-name',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
searchByName.url = (options?: RouteQueryOptions) => {
    return searchByName.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
searchByName.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: searchByName.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
searchByName.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: searchByName.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
const searchByNameForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchByName.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
searchByNameForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchByName.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\TeamController::searchByName
* @see app/Http/Controllers/TeamController.php:15
* @route '/search-by-name'
*/
searchByNameForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: searchByName.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

searchByName.form = searchByNameForm

const TeamController = { searchByName }

export default TeamController