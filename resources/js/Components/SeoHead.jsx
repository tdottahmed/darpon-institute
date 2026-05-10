import { Head, usePage } from "@inertiajs/react";

/**
 * Renders document head from shared Inertia `seo` props (see FrontendSeoResolver).
 */
export default function SeoHead() {
    const seo = usePage().props.seo;

    if (!seo || typeof seo !== "object") {
        return null;
    }

    const jsonLd = Array.isArray(seo.json_ld) ? seo.json_ld : [];

    return (
        <Head title={seo.title || undefined}>

            {seo.description ? (
                <meta
                    head-key="seo-description"
                    name="description"
                    content={seo.description}
                />
            ) : null}

            {seo.keywords ? (
                <meta
                    head-key="seo-keywords"
                    name="keywords"
                    content={seo.keywords}
                />
            ) : null}

            {seo.canonical_url ? (
                <link
                    head-key="seo-canonical"
                    rel="canonical"
                    href={seo.canonical_url}
                />
            ) : null}

            {seo.og_title ? (
                <meta
                    head-key="seo-og-title"
                    property="og:title"
                    content={seo.og_title}
                />
            ) : null}
            {seo.og_description ? (
                <meta
                    head-key="seo-og-description"
                    property="og:description"
                    content={seo.og_description}
                />
            ) : null}
            {seo.og_type ? (
                <meta
                    head-key="seo-og-type"
                    property="og:type"
                    content={seo.og_type}
                />
            ) : null}
            {seo.og_url ? (
                <meta
                    head-key="seo-og-url"
                    property="og:url"
                    content={seo.og_url}
                />
            ) : null}
            {seo.og_image ? (
                <meta
                    head-key="seo-og-image"
                    property="og:image"
                    content={seo.og_image}
                />
            ) : null}
            {seo.og_site_name ? (
                <meta
                    head-key="seo-og-site-name"
                    property="og:site_name"
                    content={seo.og_site_name}
                />
            ) : null}

            {seo.twitter_card ? (
                <meta
                    head-key="seo-twitter-card"
                    name="twitter:card"
                    content={seo.twitter_card}
                />
            ) : null}
            {seo.twitter_title ? (
                <meta
                    head-key="seo-twitter-title"
                    name="twitter:title"
                    content={seo.twitter_title}
                />
            ) : null}
            {seo.twitter_description ? (
                <meta
                    head-key="seo-twitter-description"
                    name="twitter:description"
                    content={seo.twitter_description}
                />
            ) : null}
            {seo.twitter_image ? (
                <meta
                    head-key="seo-twitter-image"
                    name="twitter:image"
                    content={seo.twitter_image}
                />
            ) : null}

            {jsonLd.map((schema, i) => (
                <script
                    key={`seo-json-ld-${i}`}
                    type="application/ld+json"
                    head-key={`seo-json-ld-${i}`}
                    dangerouslySetInnerHTML={{
                        __html: JSON.stringify(schema),
                    }}
                />
            ))}
        </Head>
    );
}

