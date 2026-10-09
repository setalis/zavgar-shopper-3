import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/cpanel/categories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \Livewire\Mechanisms\HandleRouting\LivewirePageController::__invoke
 * @see vendor/livewire/livewire/src/Mechanisms/HandleRouting/LivewirePageController.php:7
 * @route '/cpanel/categories'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
export const filters = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filters.url(args, options),
    method: 'get',
})

filters.definition = {
    methods: ["get","head"],
    url: '/cpanel/categories/{category}/filters',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
filters.url = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    category: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        category: args.category,
                }

    return filters.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
filters.get = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filters.url(args, options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
filters.head = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: filters.url(args, options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
    const filtersForm = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: filters.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
        filtersForm.get = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: filters.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
        filtersForm.head = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: filters.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    filters.form = filtersForm
const categories = {
    index: Object.assign(index, index),
filters: Object.assign(filters, filters),
}

export default categories