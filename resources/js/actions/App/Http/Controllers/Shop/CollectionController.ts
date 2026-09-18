import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
export const show = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/collections/{collection}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
show.url = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { collection: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { collection: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    collection: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        collection: typeof args.collection === 'object'
                ? args.collection.slug
                : args.collection,
                }

    return show.definition.url
            .replace('{collection}', parsedArgs.collection.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
show.get = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
show.head = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
    const showForm = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
        showForm.get = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shop\CollectionController::show
 * @see app/Http/Controllers/Shop/CollectionController.php:17
 * @route '/collections/{collection}'
 */
        showForm.head = (args: { collection: string | number | { slug: string | number } } | [collection: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
const CollectionController = { show }

export default CollectionController