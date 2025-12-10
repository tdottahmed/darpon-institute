import Container from "../ui/Container";
import SectionHeader from "../ui/SectionHeader";
import Card from "../ui/Card";
import Button from "../ui/Button";
import Badge from "../ui/Badge";
import { blogPosts } from "../../data/blogPosts";

export default function BlogSection() {
    const featuredPost = blogPosts.find((post) => post.featured);
    const regularPosts = blogPosts.filter((post) => !post.featured);

    return (
        <section className="py-16 sm:py-24 bg-white dark:bg-gray-900">
            <Container>
                <SectionHeader
                    badge="Blog"
                    title="Latest Articles"
                    subtitle="Tips, insights, and updates from our team"
                    alignment="center"
                    className="mb-12"
                />

                <div className="space-y-8">
                    {/* Featured Post */}
                    {featuredPost && (
                        <Card
                            variant="elevated"
                            padding="lg"
                            className="lg:flex gap-8 items-center"
                        >
                            <div className="lg:w-1/2 mb-6 lg:mb-0">
                                <div className="w-full h-64 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-lg flex items-center justify-center text-8xl">
                                    {featuredPost.image}
                                </div>
                            </div>
                            <div className="lg:w-1/2 space-y-4">
                                <div className="flex items-center gap-4">
                                    <Badge variant="primary">
                                        {featuredPost.category}
                                    </Badge>
                                    <span className="text-sm text-gray-600 dark:text-gray-400">
                                        {featuredPost.date}
                                    </span>
                                </div>
                                <h3 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    {featuredPost.title}
                                </h3>
                                <p className="text-gray-600 dark:text-gray-300">
                                    {featuredPost.excerpt}
                                </p>
                                <Button variant="text" href={featuredPost.link}>
                                    Read More →
                                </Button>
                            </div>
                        </Card>
                    )}

                    {/* Regular Posts Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {regularPosts.map((post) => (
                            <Card
                                key={post.id}
                                variant="default"
                                padding="lg"
                                className="hover:shadow-lg transition-shadow"
                            >
                                <div className="w-full h-48 bg-gradient-to-br from-secondary-400 to-accent-400 rounded-lg flex items-center justify-center text-6xl mb-4">
                                    {post.image}
                                </div>
                                <div className="flex items-center gap-4 mb-3">
                                    <Badge variant="secondary">
                                        {post.category}
                                    </Badge>
                                    <span className="text-sm text-gray-600 dark:text-gray-400">
                                        {post.date}
                                    </span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                    {post.title}
                                </h3>
                                <p className="text-gray-600 dark:text-gray-300 mb-4">
                                    {post.excerpt}
                                </p>
                                <Button variant="text" href={post.link}>
                                    Read More →
                                </Button>
                            </Card>
                        ))}
                    </div>
                </div>
            </Container>
        </section>
    );
}
