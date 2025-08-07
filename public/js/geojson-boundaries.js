/**
 * Indonesian Administrative Boundaries GeoJSON Data
 * This file contains administrative boundary data for mapping regions
 * 
 * Sources for real data:
 * - GADM (Global Administrative Areas): https://gadm.org/download_country.html
 * - BPS Indonesia: https://www.bps.go.id/
 * - OSM Indonesia: https://openstreetmap.org/
 * - HDX OCHA: https://data.humdata.org/dataset/cod-ab-idn
 */

class IndonesiaBoundaries {
    constructor() {
        this.baseApiUrl = 'https://raw.githubusercontent.com/indonesia-geojson/indonesia-geojson/master/';
        this.localBoundaries = this.getLocalBoundaries();
    }

    /**
     * Fetch real administrative boundaries from external source
     * @param {string} level - Administrative level (province, kabupaten, kecamatan)
     * @param {string} region - Region name or code
     * @returns {Promise<Object>} GeoJSON data
     */
    async fetchRealBoundaries(level, region) {
        const urls = [
            // Primary sources for real data
            `https://raw.githubusercontent.com/indonesia-geojson/indonesia-geojson/master/${level}/${region}.geojson`,
            `https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/${level}/${region}.json`,
            `https://data.humdata.org/api/action/datastore_search?resource_id=${this.getResourceId(level, region)}`
        ];

        for (const url of urls) {
            try {
                const response = await fetch(url);
                if (response.ok) {
                    const data = await response.json();
                    return this.normalizeGeoJSON(data);
                }
            } catch (error) {
                console.warn(`Failed to fetch from ${url}:`, error);
            }
        }

        // Fallback to local simplified boundaries
        return this.getLocalBoundaries()[region] || null;
    }

    /**
     * Get resource ID for HDX OCHA data
     */
    getResourceId(level, region) {
        const resourceMap = {
            'kabupaten': {
                'west-java': '53625e84-203d-4331-b3eb-01e6e8344413'
            }
        };
        return resourceMap[level]?.[region] || '';
    }

    /**
     * Normalize different GeoJSON formats to standard structure
     */
    normalizeGeoJSON(data) {
        // Handle different response formats
        if (data.result && data.result.records) {
            // HDX format
            return this.convertHDXToGeoJSON(data.result.records);
        }
        
        // Standard GeoJSON
        return data;
    }

    /**
     * Convert HDX data to GeoJSON format
     */
    convertHDXToGeoJSON(records) {
        return {
            type: "FeatureCollection",
            features: records.map(record => ({
                type: "Feature",
                properties: {
                    name: record.ADM2_EN || record.name,
                    code: record.ADM2_PCODE || record.code,
                    type: record.ADM2_TYPE || 'kabupaten'
                },
                geometry: JSON.parse(record.geometry || '{}')
            }))
        };
    }

    /**
     * Get local simplified boundaries (fallback)
     * These are simplified for performance but can be replaced with real data
     */
    getLocalBoundaries() {
        return {
            // West Java Kabupaten/Kota boundaries
            'cirebon': {
                type: "FeatureCollection",
                features: [{
                    type: "Feature",
                    properties: {
                        name: "Kabupaten Cirebon",
                        code: "3209",
                        type: "kabupaten",
                        province: "Jawa Barat"
                    },
                    geometry: {
                        type: "Polygon",
                        coordinates: [[
                            [108.4, -6.9], [108.8, -6.9], [108.8, -6.6], 
                            [108.4, -6.6], [108.4, -6.9]
                        ]]
                    }
                }]
            },
            'cirebon-city': {
                type: "FeatureCollection",
                features: [{
                    type: "Feature",
                    properties: {
                        name: "Kota Cirebon",
                        code: "3274",
                        type: "kota",
                        province: "Jawa Barat"
                    },
                    geometry: {
                        type: "Polygon",
                        coordinates: [[
                            [108.55, -6.75], [108.58, -6.75], [108.58, -6.72], 
                            [108.55, -6.72], [108.55, -6.75]
                        ]]
                    }
                }]
            },
            'indramayu': {
                type: "FeatureCollection",
                features: [{
                    type: "Feature",
                    properties: {
                        name: "Kabupaten Indramayu",
                        code: "3212",
                        type: "kabupaten",
                        province: "Jawa Barat"
                    },
                    geometry: {
                        type: "Polygon",
                        coordinates: [[
                            [107.8, -6.4], [108.4, -6.4], [108.4, -6.0], 
                            [107.8, -6.0], [107.8, -6.4]
                        ]]
                    }
                }]
            },
            'kuningan': {
                type: "FeatureCollection",
                features: [{
                    type: "Feature",
                    properties: {
                        name: "Kabupaten Kuningan",
                        code: "3208",
                        type: "kabupaten",
                        province: "Jawa Barat"
                    },
                    geometry: {
                        type: "Polygon",
                        coordinates: [[
                            [108.4, -7.0], [108.8, -7.0], [108.8, -6.8], 
                            [108.4, -6.8], [108.4, -7.0]
                        ]]
                    }
                }]
            },
            'majalengka': {
                type: "FeatureCollection",
                features: [{
                    type: "Feature",
                    properties: {
                        name: "Kabupaten Majalengka",
                        code: "3210",
                        type: "kabupaten",
                        province: "Jawa Barat"
                    },
                    geometry: {
                        type: "Polygon",
                        coordinates: [[
                            [108.0, -6.9], [108.4, -6.9], [108.4, -6.7], 
                            [108.0, -6.7], [108.0, -6.9]
                        ]]
                    }
                }]
            }
        };
    }

    /**
     * Get boundaries for specific regions
     * @param {Array} regions - Array of region names
     * @returns {Promise<Object>} Combined GeoJSON
     */
    async getBoundariesForRegions(regions) {
        const features = [];
        
        for (const region of regions) {
            try {
                // Try to fetch real data first
                const realData = await this.fetchRealBoundaries('kabupaten', region);
                if (realData && realData.features) {
                    features.push(...realData.features);
                }
            } catch (error) {
                console.warn(`Failed to load boundaries for ${region}:`, error);
            }
        }

        return {
            type: "FeatureCollection",
            features: features
        };
    }

    /**
     * Download and cache real boundary data
     * Instructions for getting real data:
     * 
     * 1. GADM Data (Recommended):
     *    - Visit: https://gadm.org/download_country.html
     *    - Download Indonesia Level 2 (Admin 2) GeoJSON
     *    - Extract and filter for your regions
     * 
     * 2. BPS Indonesia:
     *    - Visit: https://www.bps.go.id/
     *    - Download Shapefile data
     *    - Convert to GeoJSON using QGIS or online tools
     * 
     * 3. OSM Data:
     *    - Use Overpass API to query administrative boundaries
     *    - Export as GeoJSON
     * 
     * 4. HDX OCHA:
     *    - Visit: https://data.humdata.org/dataset/cod-ab-idn
     *    - Download the SHP or GeoJSON files
     */
    getDataSources() {
        return {
            gadm: "https://gadm.org/download_country.html - Global Administrative Areas",
            bps: "https://www.bps.go.id/ - Statistics Indonesia",
            osm: "https://overpass-api.de/ - OpenStreetMap Overpass API",
            hdx: "https://data.humdata.org/dataset/cod-ab-idn - OCHA Humanitarian Data",
            github: "https://github.com/indonesia-geojson/ - Community maintained",
            instructions: `
To use real boundary data:
1. Download from any of the sources above
2. Place GeoJSON files in: public/geojson/boundaries/
3. Update the file paths in this script
4. The system will automatically use real data when available
            `
        };
    }
}

// Create global instance
window.IndonesiaBoundaries = new IndonesiaBoundaries();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = IndonesiaBoundaries;
}
