import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { readdirSync, existsSync } from 'fs';
import { resolve } from 'path';

async function getAllPaths()
{

    const domainPath = resolve(__dirname, 'platform');

    const allPaths = [
        'resources/js/app.js',
        'resources/css/app.css',
    ];
    
    const mainDirs = ['core', 'modules', 'themes'];

    for (const mainDir of mainDirs)
    {
        const mainDirPath = resolve(domainPath, mainDir);

        const subDirs = readdirSync(mainDirPath, { withFileTypes: true })
            .filter(dirent => dirent.isDirectory()) // Chỉ lấy các thư mục
            .map(dirent => dirent.name);

        for (const subDir of subDirs)
        {
            const configPath = resolve(mainDirPath, subDir, 'vite.config.js');
            
            try {

                if(existsSync(configPath))
                {
                    // Sử dụng import() để lấy cấu hình module
                    const viteConfig = await import(configPath);

                    // // Kiểm tra nếu export const paths tồn tại và là một mảng
                    if (viteConfig.paths && Array.isArray(viteConfig.paths))
                    {
                        // Thêm 'platform/' vào đầu mỗi phần tử của paths
                        const updatedPaths = viteConfig.paths.map(path => resolve(mainDirPath, subDir, path).replace(__dirname + '/', ''));

                        allPaths.push(...updatedPaths); // Hợp nhất các đường dẫn
                    }
                }
                
            } catch (error) {
                console.error(`Không thể tải cấu hình cho module ${module}:`, error);
            }
        }
    }
    
    console.log(allPaths);
    return allPaths;
}

async function getConfig() {
    const paths = await getAllPaths();
    return defineConfig({
        plugins: [
            laravel({
                input: paths,
                refresh: true,
            }),
        ]
    });
}

export default getConfig();
