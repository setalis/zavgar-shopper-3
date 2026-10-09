import PendingProducts from './PendingProducts'
import BlacklistedProducts from './BlacklistedProducts'
import CategoryFilters from './CategoryFilters'
import HomepageBanners from './HomepageBanners'
import MenuItems from './MenuItems'
import News from './News'
const Pages = {
    PendingProducts: Object.assign(PendingProducts, PendingProducts),
BlacklistedProducts: Object.assign(BlacklistedProducts, BlacklistedProducts),
CategoryFilters: Object.assign(CategoryFilters, CategoryFilters),
HomepageBanners: Object.assign(HomepageBanners, HomepageBanners),
MenuItems: Object.assign(MenuItems, MenuItems),
News: Object.assign(News, News),
}

export default Pages