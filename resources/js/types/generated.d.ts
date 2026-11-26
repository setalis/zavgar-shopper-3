declare namespace App {
    namespace DTO {
        export type AddressData = {
            firstName: string | null;
            lastName: string | null;
            company: string | null;
            streetAddress: string;
            streetAddressPlus: string | null;
            postalCode: string;
            city: string;
            phoneNumber: string | null;
            countryId: number;
        };
        export type BundleComponentData = {
            productId: number;
            variantId: number | null;
            name: string;
            variantName: string | null;
            slug: string | null;
            sku: string | null;
            thumbnail: string | null;
            quantity: number;
            unitAmount: number | null;
            isAvailable: boolean;
        };
        export type BundleCompositionData = {
            items: App.DTO.BundleComponentData[];
            componentsTotal: number | null;
            bundleAmount: number | null;
            savings: number | null;
            stock: number;
        };
        export type CountryByZoneData = {
            zoneId: number;
            zoneCode: string | null;
            zoneName: string;
            countryId: number;
            countryName: string;
            countryCode: string;
            countryFlag: string;
            currencyCode: string;
        };
        export type PriceData = {
            amount: undefined;
            compare: undefined | null;
            percentage: number | null;
        };
        export type ProductReviewsData = {
            reviews: undefined;
            averageRating: number;
            totalCount: number;
        };
    }
}
