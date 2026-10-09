import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
const Edit = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})

Edit.definition = {
    methods: ["get","head"],
    url: '/cpanel/categories/{category}/filters',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
Edit.url = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return Edit.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
Edit.get = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
Edit.head = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
    const EditForm = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: Edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
        EditForm.get = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\CategoryFilters\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/CategoryFilters/Edit.php:7
 * @route '/cpanel/categories/{category}/filters'
 */
        EditForm.head = (args: { category: string | number } | [category: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    Edit.form = EditForm
export default Edit