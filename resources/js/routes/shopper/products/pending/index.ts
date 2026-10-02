import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/pending',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\PendingProducts\Index::__invoke
 * @see app/Livewire/Shopper/Pages/PendingProducts/Index.php:7
 * @route '/cpanel/products/pending'
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
const pending = {
    index: Object.assign(index, index),
}

export default pending