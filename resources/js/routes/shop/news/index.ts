import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
export const show = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/news/{article}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
show.url = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { article: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    article: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        article: typeof args.article === 'object'
                ? args.article.slug
                : args.article,
                }

    return show.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
show.get = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
show.head = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
    const showForm = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
        showForm.get = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shop\NewsController::show
 * @see app/Http/Controllers/Shop/NewsController.php:32
 * @route '/news/{article}'
 */
        showForm.head = (args: { article: string | { slug: string } } | [article: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
const news = {
    show: Object.assign(show, show),
}

export default news