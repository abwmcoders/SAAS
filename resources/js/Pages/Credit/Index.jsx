import CreditPricingCards from "@/Components/CreditPricingCards";
import Authenticated from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";


export default function Index({ auth, packages, features, success, error }) {
    const availableCredits = auth.user.available_credits;

    return (
        <Authenticated
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Your Credits
            </h2>}
        >
            <Head title="Your Credits" />

            <div className="py-1">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {success && (
                        <div className="mb-4 py-3 px-5 rounded text-white text-xl bg-emerald-600">
                            { success }
                        </div>
                    )}
                    {error && (
                        <div className="mb-4 py-3 px-5 rounded text-white text-xl bg-red-600">
                            { error }
                        </div>
                    )}

                    <div className="bg-gray-800 dark:bg-gray-800 overflow-hidden shadow-sm sm-rounded-lg relative">
                        <div className="flex flex-col gap-3 item-center justify-center p-4">
                            <img src="/img/coin.png" alt="" className="w-[100px]" />
                            <h3 className="text-2xl text-white">
                                You have { availableCredits} Credits.
                            </h3>
                        </div>
                    </div>
                    <CreditPricingCards packages={ packages.data } features={ features.data } />
                </div>
            </div>

        </Authenticated>
    )

}